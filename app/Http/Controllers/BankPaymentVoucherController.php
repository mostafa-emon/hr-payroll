<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuickBook;
use App\Setting;
use Auth;
use App\VoucherFormat;
use App\Voucher;
use App\Currency;
use DateTime;
use App\Company;

class BankPaymentVoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $company = Company::where('id',Auth::user()->company_id)->first();

        if($request->from_date != "" && $request->to_date != "") {

            $datetime1 = new DateTime($request->from_date);
            $datetime2 = new DateTime($request->to_date);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            if($days > 31) {
                return redirect('tr-cash-payment-voucher')->with('message','Date range should not greater than one month!');
            }

            $type = $request->trx_type;
            $payee_name = $request->payee_name;
            $amount = $request->amount;
            $memo = $request->memo;

            $from_date = date('Y-m-d',strtotime($request->from_date));
            $to_date = date('Y-m-d',strtotime($request->to_date));
            
            $token = getToken();
            $index = -1;
            $data = [];
            $CashOnHandID = [];
            $whereInIDs = "";

            // GET CASH_ON_HAND ACCOUNTS
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/query?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"SELECT * FROM Account",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: Token ".$token,
                "Accept: application/json",
                "Content-Type: application/text",
                "Authorization: Bearer ".$token,
                "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $accounts = json_decode($response, true);
            
            $resultCount = $accounts['QueryResponse']['maxResults'] - 1;
            if($resultCount > -1){
                for($i = 0; $i <= $resultCount; $i++) {
                    if($accounts['QueryResponse']['Account'][$i]['AccountSubType'] == "Checking"
                     || $accounts['QueryResponse']['Account'][$i]['AccountSubType'] == "MoneyMarket"
                     || $accounts['QueryResponse']['Account'][$i]['AccountSubType'] == "RentsHeldInTrust"
                     || $accounts['QueryResponse']['Account'][$i]['AccountSubType'] == "Savings"
                     || $accounts['QueryResponse']['Account'][$i]['AccountSubType'] == "TrustAccounts"
                    ){
                        $CashOnHandID[] = $accounts['QueryResponse']['Account'][$i]['Id'];
                        $whereInIDs = $whereInIDs.",'".$accounts['QueryResponse']['Account'][$i]['Id']."'";
                    }
                }
            }
            $whereInIDs = ltrim($whereInIDs,',');

            if(count($CashOnHandID) != 0) {
                // GET DATA FROM PURCHASE
                if($type == 'all' || $type == 'expense' || $type == 'cheque') {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/query?minorversion=14",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS =>"SELECT AccountRef,TxnDate,EntityRef,PrivateNote,TotalAmt,DocNumber,PaymentType FROM Purchase WHERE TxnDate >= '$from_date' AND TxnDate <= '$to_date'",
                    CURLOPT_HTTPHEADER => array(
                        "User-Agent: Token ".$token,
                        "Accept: application/json",
                        "Content-Type: application/text",
                        "Authorization: Bearer ".$token,
                        "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
                    ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);

                    $results = json_decode($response, true);
                    if(isset($results['QueryResponse']['maxResults'])){
                        $resultCount = $results['QueryResponse']['maxResults'] - 1;
                        if($resultCount > -1){
                            for($i = 0; $i <= $resultCount; $i++) {
                                if(in_array($results['QueryResponse']['Purchase'][$i]['AccountRef']['value'], $CashOnHandID)){
                                    //Filters
                                    if($payee_name != "") {
                                        if(!isset($results['QueryResponse']['Purchase'][$i]['EntityRef']['name'])) {
                                            continue;
                                        }
                                        if(strpos(strtolower($results['QueryResponse']['Purchase'][$i]['EntityRef']['name']), strtolower($payee_name)) === FALSE){
                                            continue;
                                        }
                                    }
                                    if($amount != "" && $results['QueryResponse']['Purchase'][$i]['TotalAmt'] != $amount) { continue; }
                                    if($memo != "") { 
                                        if(!isset($results['QueryResponse']['Purchase'][$i]['PrivateNote'])) {
                                            continue;
                                        }
                                        if(strpos(strtolower($results['QueryResponse']['Purchase'][$i]['PrivateNote']), strtolower($memo)) === FALSE){
                                            continue;
                                        }
                                    }
                                    if($type == 'cheque' && $results['QueryResponse']['Purchase'][$i]['PaymentType'] != "Check") { continue; }
                                    if($type == 'expense' && $results['QueryResponse']['Purchase'][$i]['PaymentType'] != "Cash") { continue; }

                                    $index = $index + 1;
                                    
                                    $data[$index]['Id'] = $results['QueryResponse']['Purchase'][$i]['Id'];
                                    $data[$index]['TxnDate'] = $results['QueryResponse']['Purchase'][$i]['TxnDate'];
                                    if($results['QueryResponse']['Purchase'][$i]['PaymentType'] == "Cash"){
                                        $data[$index]['TxnType'] = 'Expense';
                                    }else{
                                        $data[$index]['TxnType'] = $results['QueryResponse']['Purchase'][$i]['PaymentType'];
                                    }
                                    
                                    if(isset($results['QueryResponse']['Purchase'][$i]['DocNumber'])){
                                        $data[$index]['DocNumber'] = $results['QueryResponse']['Purchase'][$i]['DocNumber'];
                                    }else{
                                        $data[$index]['DocNumber'] = "";
                                    }
                                    if(isset($results['QueryResponse']['Purchase'][$i]['EntityRef']['name'])){
                                        $data[$index]['PayeeName'] = $results['QueryResponse']['Purchase'][$i]['EntityRef']['name'];
                                    }else{
                                        $data[$index]['PayeeName'] = "";
                                    }
                                    $data[$index]['PaidFrom'] = $results['QueryResponse']['Purchase'][$i]['AccountRef']['name'];
                                    if(isset($results['QueryResponse']['Purchase'][$i]['PrivateNote'])){
                                        $data[$index]['Memo'] = $results['QueryResponse']['Purchase'][$i]['PrivateNote'];
                                    }else{
                                        $data[$index]['Memo'] = "";
                                    }
                                    $data[$index]['TotalAmt'] = $results['QueryResponse']['Purchase'][$i]['TotalAmt'];
                                }
                            }
                        }
                    }
                }

                // GET DATA FROM BILL PAYMENT
                if($type == 'all' || $type == 'pay_bills') {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/query?minorversion=14",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS =>"SELECT * FROM BillPayment WHERE BankAccountRef IN ($whereInIDs) AND TxnDate >= '$from_date' AND TxnDate <= '$to_date'",
                    CURLOPT_HTTPHEADER => array(
                        "User-Agent: Token ".$token,
                        "Accept: application/json",
                        "Content-Type: application/text",
                        "Authorization: Bearer ".$token,
                        "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
                    ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);

                    $results = json_decode($response, true);
                    if(isset($results['QueryResponse']['maxResults'])) {
                        $resultCount = $results['QueryResponse']['maxResults'] - 1;
                        if($resultCount > -1){
                            for($i = 0; $i <= $resultCount; $i++) {
                                if(isset($results['QueryResponse']['BillPayment'][$i]['CheckPayment']['BankAccountRef']['value'])) {
                                    if(in_array($results['QueryResponse']['BillPayment'][$i]['CheckPayment']['BankAccountRef']['value'], $CashOnHandID)){
                                        //Filters
                                        if($payee_name != "") {
                                            if(!isset($results['QueryResponse']['BillPayment'][$i]['VendorRef']['name'])) {
                                                continue;
                                            }
                                            if(strpos(strtolower($results['QueryResponse']['BillPayment'][$i]['VendorRef']['name']), strtolower($payee_name)) === FALSE){
                                                continue;
                                            }
                                        }
                                        if($amount != "" && $results['QueryResponse']['BillPayment'][$i]['TotalAmt'] != $amount) { continue; }
                                        if($memo != "") { 
                                            if(!isset($results['QueryResponse']['BillPayment'][$i]['PrivateNote'])) {
                                                continue;
                                            }
                                            if(strpos(strtolower($results['QueryResponse']['BillPayment'][$i]['PrivateNote']), strtolower($memo)) === FALSE){
                                                continue;
                                            }
                                        }

                                        $index = $index + 1;
                                        $data[$index]['Id'] = $results['QueryResponse']['BillPayment'][$i]['Id'];
                                        $data[$index]['TxnDate'] = $results['QueryResponse']['BillPayment'][$i]['TxnDate'];
                                        $data[$index]['TxnType'] = 'Pay Bills';
                                        if(isset($results['QueryResponse']['BillPayment'][$i]['DocNumber'])){
                                            $data[$index]['DocNumber'] = $results['QueryResponse']['BillPayment'][$i]['DocNumber'];
                                        }else{
                                            $data[$index]['DocNumber'] = "";
                                        }
                                        if(isset($results['QueryResponse']['BillPayment'][$i]['VendorRef']['name'])){
                                            $data[$index]['PayeeName'] = $results['QueryResponse']['BillPayment'][$i]['VendorRef']['name'];
                                        }else{
                                            $data[$index]['PayeeName'] = "";
                                        }
                                        $data[$index]['PaidFrom'] = $results['QueryResponse']['BillPayment'][$i]['CheckPayment']['BankAccountRef']['name'];
                                        if(isset($results['QueryResponse']['BillPayment'][$i]['PrivateNote'])){
                                            $data[$index]['Memo'] = $results['QueryResponse']['BillPayment'][$i]['PrivateNote'];
                                        }else{
                                            $data[$index]['Memo'] = "";
                                        }
                                        $data[$index]['TotalAmt'] = $results['QueryResponse']['BillPayment'][$i]['TotalAmt'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return view('vouchers.bank_payment',compact('data','from_date','to_date','type','payee_name','amount','memo'));
        }
        
        else{
            $type = "";
            $payee_name = "";
            $amount = "";
            $memo = "";
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data = [];
            return view('vouchers.bank_payment',compact('data','from_date','to_date','type','payee_name','amount','memo'));
        }
    }

    public function preview($print_status,$api_type,$id){
        $voucher_type = "Bank-Payment-Voucher";
        $data = $this->bank_payment_voucher_print($api_type,$id);
        $voucher_formats = VoucherFormat::select('id','title','default')->where('company_id',Auth::user()->company_id)->where('type',$voucher_type)->get();
        $settings = Setting::where('company_id',Auth::user()->company_id)->first();
        $currencies = Currency::where('company_id',Auth::user()->company_id)->get();
        $defaults = Currency::where('company_id',Auth::user()->company_id)->where('default',1)->first();
        return view('vouchers.print_preview',compact('print_status','settings','currencies','data','voucher_type','api_type','voucher_formats','defaults'));
    }

    public function bank_payment_voucher_print($api_type,$id){
        $company = Company::where('id',Auth::user()->company_id)->first();
        $token = getToken();
        $data = [];
        $settings = Setting::where('company_id',Auth::user()->company_id)->first(); 
        
        if($api_type == 'expense' || $api_type == 'cheque') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/purchase/".$id."?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: Token ".$token,
                "Accept: application/json",
                "Authorization: Bearer ".$token,
                "Cookie: qboeuid=273f06cf.5a8393ed07b56"
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $results = json_decode($response, true);

            if($settings->voucher_number == "auto"){
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Bank-Payment-Voucher')->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = $settings->bank_payment_voucher_start_from;
                }else{
                    if($settings->bank_payment_voucher_prefix == $latest_voucher->prefix && $settings->bank_payment_voucher_suffix == $latest_voucher->suffix){
                        $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                    }else{
                        $data['voucher_no'] = $settings->bank_payment_voucher_start_from;
                    }
                }
                $data['prefix'] = $settings->bank_payment_voucher_prefix;
                $data['suffix'] = $settings->bank_payment_voucher_suffix;
            }else{
                $data['voucher_no'] = "";
                $data['prefix'] = "";
                $data['suffix'] = "";
            }
            $data['id'] = $results['Purchase']['Id'];
            $data['voucher_date'] = $results['Purchase']['TxnDate'];
            if(isset($results['Purchase']['DocNumber'])){
                $data['reference_no'] = $results['Purchase']['DocNumber'];
            }else{
                $data['reference_no'] = "";
            }
            
            if(isset($results['Purchase']['EntityRef']['name'])){
                $data['payee_name'] = $results['Purchase']['EntityRef']['name'];
            }else{
                $data['payee_name'] = "";
            }
            $data['received_from'] = "";
            $data['cheque_no'] = "";
            $data['cheque_date'] = "";
            if(isset($results['Purchase']['DepartmentRef']['name'])){
                $data['location'] = $results['Purchase']['DepartmentRef']['name'];
            }else{
                $data['location'] = "";
            }
            if(isset($results['Purchase']['PrivateNote'])){
                $data['memo'] = $results['Purchase']['PrivateNote'];
            }else{
                $data['memo'] = "";
            }
            $data['PaidFrom'] = $results['Purchase']['AccountRef']['name'];
            $data['transactions'] = [];
            $count_debits = count($results['Purchase']['Line']) - 1;
            if($count_debits > -1){
                for($i = 0; $i <= $count_debits; $i++) {
                    if($results['Purchase']['Line'][$i]['DetailType'] == "AccountBasedExpenseLineDetail") {
                        $data['transactions'][$i]['account_code_name'] = $results['Purchase']['Line'][$i]['AccountBasedExpenseLineDetail']['AccountRef']['name'];
                        if(isset($results['Purchase']['Line'][$i]['Description'])){
                            $data['transactions'][$i]['memo'] = $results['Purchase']['Line'][$i]['Description'];
                        }else{
                            $data['transactions'][$i]['memo'] = "";
                        }
                        if(isset($results['Purchase']['Line'][$i]['AccountBasedExpenseLineDetail']['CustomerRef']['name'])){
                            $data['transactions'][$i]['customer_job_project_name'] = $results['Purchase']['Line'][$i]['AccountBasedExpenseLineDetail']['CustomerRef']['name'];
                        }else{
                            $data['transactions'][$i]['customer_job_project_name'] = "";
                        }
                        if(isset($results['Purchase']['Line'][$i]['AccountBasedExpenseLineDetail']['ClassRef']['name'])){
                            $data['transactions'][$i]['class'] = $results['Purchase']['Line'][$i]['AccountBasedExpenseLineDetail']['ClassRef']['name'];
                        }else{
                            $data['transactions'][$i]['class'] = "";
                        }
                        $data['transactions'][$i]['debit'] = $results['Purchase']['Line'][$i]['Amount'];
                        $data['transactions'][$i]['credit'] = "";
                    }
                    else if($results['Purchase']['Line'][$i]['DetailType'] == "ItemBasedExpenseLineDetail") {
                        
                        // ACCOUNT NAME FROM ITEM API
                        $item_id = $results['Purchase']['Line'][$i]['ItemBasedExpenseLineDetail']['ItemRef']['value'];
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/item/".$item_id."?minorversion=14",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            "User-Agent: Token ".$token,
                            "Accept: application/json",
                            "Content-Type: application/text",
                            "Authorization: Bearer ".$token,
                            "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
                        ),
                        ));

                        $response = curl_exec($curl);
                        curl_close($curl);

                        $items = json_decode($response, true);

                        $data['transactions'][$i]['account_code_name'] = $items['Item']['AssetAccountRef']['name'];
                        
                        if(isset($results['Purchase']['Line'][$i]['Description'])){
                            $data['transactions'][$i]['memo'] = $results['Purchase']['Line'][$i]['Description'];
                        }else{
                            $data['transactions'][$i]['memo'] = "";
                        }
                        if(isset($results['Purchase']['Line'][$i]['ItemBasedExpenseLineDetail']['CustomerRef']['name'])){
                            $data['transactions'][$i]['customer_job_project_name'] = $results['Purchase']['Line'][$i]['ItemBasedExpenseLineDetail']['CustomerRef']['name'];
                        }else{
                            $data['transactions'][$i]['customer_job_project_name'] = "";
                        }
                        if(isset($results['Purchase']['Line'][$i]['ItemBasedExpenseLineDetail']['ClassRef']['name'])){
                            $data['transactions'][$i]['class'] = $results['Purchase']['Line'][$i]['ItemBasedExpenseLineDetail']['ClassRef']['name'];
                        }else{
                            $data['transactions'][$i]['class'] = "";
                        }
                        $data['transactions'][$i]['debit'] = $results['Purchase']['Line'][$i]['Amount'];
                        $data['transactions'][$i]['credit'] = "";
                    }
                    
                }
            }

            $i = $i + 1;
            $data['transactions'][$i]['account_code_name'] = $results['Purchase']['AccountRef']['name'];
            if(isset($results['Purchase']['PrivateNote'])){
                $data['transactions'][$i]['memo'] = $results['Purchase']['PrivateNote'];
            }else{
                $data['transactions'][$i]['memo'] = "";
            }
            $data['transactions'][$i]['customer_job_project_name'] = "";
            $data['transactions'][$i]['class'] = "";
            $data['transactions'][$i]['debit'] = "";
            $data['transactions'][$i]['credit'] = $results['Purchase']['TotalAmt'];
            return $data; 
        }
        

        if($api_type == 'bill_payment') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/billpayment/".$id."?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: Token ".$token,
                "Accept: application/json",
                "Content-Type: application/text",
                "Authorization: Bearer ".$token,
                "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $results = json_decode($response, true);

            if($settings->voucher_number == "auto"){
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Bank-Payment-Voucher')->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = $settings->bank_payment_voucher_start_from;
                }else{
                    if($settings->bank_payment_voucher_prefix == $latest_voucher->prefix && $settings->bank_payment_voucher_suffix == $latest_voucher->suffix){
                        $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                    }else{
                        $data['voucher_no'] = $settings->bank_payment_voucher_start_from;
                    }
                }
                $data['prefix'] = $settings->bank_payment_voucher_prefix;
                $data['suffix'] = $settings->bank_payment_voucher_suffix;
            }else{
                $data['voucher_no'] = "";
                $data['prefix'] = "";
                $data['suffix'] = "";
            }
            $data['id'] = $results['BillPayment']['Id'];
            $data['voucher_date'] = $results['BillPayment']['TxnDate'];
            if(isset($results['BillPayment']['DocNumber'])){
                $data['reference_no'] = $results['BillPayment']['DocNumber'];
            }else{
                $data['reference_no'] = "";
            }
            if(isset($results['BillPayment']['VendorRef']['name'])){
                $data['payee_name'] = $results['BillPayment']['VendorRef']['name'];
            }else{
                $data['payee_name'] = "";
            }
            $data['received_from'] = "";
            $data['cheque_no'] = "";
            $data['cheque_date'] = "";
            $data['location'] = "";
            if(isset($results['BillPayment']['PrivateNote'])){
                $data['memo'] = $results['BillPayment']['PrivateNote'];
            }else{
                $data['memo'] = "";
            }
            $data['PaidFrom'] = $results['BillPayment']['CheckPayment']['BankAccountRef']['name'];

            $bill_id = $results['BillPayment']['Line'][0]['LinkedTxn'][0]['TxnId'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/bill/".$bill_id."?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: Token ".$token,
                "Accept: application/json",
                "Content-Type: application/text",
                "Authorization: Bearer ".$token,
                "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $bills = json_decode($response, true);

            $data['transactions'] = [];

            $data['transactions'][0]['account_code_name'] = $bills['Bill']['APAccountRef']['name'];
            $data['transactions'][0]['memo'] = $results['BillPayment']['VendorRef']['name'];
            $data['transactions'][0]['customer_job_project_name'] = "";
            $data['transactions'][0]['class'] = "";
            $data['transactions'][0]['debit'] = $results['BillPayment']['TotalAmt'];
            $data['transactions'][0]['credit'] = "";

            $data['transactions'][1]['account_code_name'] = $results['BillPayment']['CheckPayment']['BankAccountRef']['name'];
            $data['transactions'][1]['memo'] = "";
            $data['transactions'][1]['customer_job_project_name'] = "";
            $data['transactions'][1]['class'] = "";
            $data['transactions'][1]['debit'] = "";
            $data['transactions'][1]['credit'] = $results['BillPayment']['TotalAmt'];
            
            return $data;
        }
    }
}
