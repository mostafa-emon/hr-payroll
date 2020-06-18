<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuickBook;
use App\Setting;
use Auth;
use App\VoucherFormat;
use App\Voucher;
use App\Currency;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cash_payment(Request $request){
        if($request->from_date != "" && $request->to_date != "") {
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
            CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/query?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"SELECT * FROM Account WHERE AccountType = 'Bank' AND AccountSubType = 'CashOnHand'",
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
                    $CashOnHandID[] = $accounts['QueryResponse']['Account'][$i]['Id'];
                    $whereInIDs = $whereInIDs.",'".$accounts['QueryResponse']['Account'][$i]['Id']."'";
                }
            }
            $whereInIDs = ltrim($whereInIDs,',');

            // GET DATA FROM PURCHASE
            if($type == 'all' || $type == 'expense') {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/query?minorversion=14",
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

                if($response != "") {
                    $results = json_decode($response, true);
                    $resultCount = $results['QueryResponse']['maxResults'] - 1;
                    if($resultCount > -1){
                        for($i = 0; $i <= $resultCount; $i++) {
                            if(in_array($results['QueryResponse']['Purchase'][$i]['AccountRef']['value'], $CashOnHandID)){
                                
                                //Filters
                                if($payee_name != "" && $results['QueryResponse']['Purchase'][$i]['EntityRef']['name'] != $payee_name) { continue; }
                                if($amount != "" && $results['QueryResponse']['Purchase'][$i]['TotalAmt'] != $amount) { continue; }
                                if($memo != "") { 
                                    if(!isset($results['QueryResponse']['Purchase'][$i]['PrivateNote'])) {
                                        continue;
                                    }
                                    if(strpos($results['QueryResponse']['Purchase'][$i]['PrivateNote'], $memo) === FALSE){
                                        continue;
                                    }
                                }
                                
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
                                $data[$index]['PayeeName'] = $results['QueryResponse']['Purchase'][$i]['EntityRef']['name'];
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
                CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/query?minorversion=14",
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

                if($response != ""){
                    $results = json_decode($response, true);
                    $resultCount = $results['QueryResponse']['maxResults'] - 1;
                    if($resultCount > -1){
                        for($i = 0; $i <= $resultCount; $i++) {
                            if(isset($results['QueryResponse']['BillPayment'][$i]['CheckPayment']['BankAccountRef']['value'])) {
                                if(in_array($results['QueryResponse']['BillPayment'][$i]['CheckPayment']['BankAccountRef']['value'], $CashOnHandID)){
                                    //Filters
                                    if($payee_name != "" && $results['QueryResponse']['BillPayment'][$i]['VendorRef']['name'] != $payee_name) { continue; }
                                    if($amount != "" && $results['QueryResponse']['BillPayment'][$i]['TotalAmt'] != $amount) { continue; }
                                    if($memo != "") { 
                                        if(!isset($results['QueryResponse']['BillPayment'][$i]['PrivateNote'])) {
                                            continue;
                                        }
                                        if(strpos($results['QueryResponse']['BillPayment'][$i]['PrivateNote'], $memo) === FALSE){
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
                                    $data[$index]['PayeeName'] = $results['QueryResponse']['BillPayment'][$i]['VendorRef']['name'];
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

            return view('vouchers.cash_payment',compact('data','from_date','to_date','type','payee_name','amount','memo'));
        }
        
        else{
            $type = "";
            $payee_name = "";
            $amount = "";
            $memo = "";
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data = [];
            return view('vouchers.cash_payment',compact('data','from_date','to_date','type','payee_name','amount','memo'));
        }
    }
    
    public function bank_payment(){
        return view('vouchers.bank_payment');
    }

    public function cash_receipt(){
        return view('vouchers.cash_receipt');
    }

    public function bank_receipt(){
        return view('vouchers.bank_receipt');
    }


    public function contra_voucher(){
        return view('vouchers.contra');
    }

    public function journal_voucher(){
        return view('vouchers.journal');
    }

    public function print($voucher_type,$api_type,$id){
        if($voucher_type == "Cash-Payment-Voucher") {
            $data = $this->cash_payment_voucher_print($api_type,$id);
            $voucher_formats = VoucherFormat::select('id','title')->where('company_id',Auth::user()->company_id)->where('type',$voucher_type)->get();
            $settings = Setting::where('company_id',Auth::user()->company_id)->first();
            $currency = Currency::where('company_id',Auth::user()->company_id)->where('default',1)->first();
            return view('vouchers.print_preview',compact('settings','currency','data','voucher_type','api_type','voucher_formats'));
        }
    }

    public function cash_payment_voucher_print($api_type,$id){
        $token = getToken();
        $data = [];
        $settings = Setting::where('company_id',Auth::user()->company_id)->first(); 
        
        if($api_type == 'expense') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/purchase/".$id."?minorversion=14",
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
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = 1;
                }else{
                    $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                }
            }else{
                $data['voucher_no'] = "";
            }

            $data['voucher_date'] = $results['Purchase']['TxnDate'];
            if(isset($results['Purchase']['DocNumber'])){
                $data['reference_no'] = $results['Purchase']['DocNumber'];
            }else{
                $data['reference_no'] = "";
            }
            $data['payee_name'] = $results['Purchase']['EntityRef']['name'];
            $data['received_from'] = "";
            $data['cheque_no'] = "";
            $data['cheque_date'] = "";
            if(isset($results['Purchase']['DepartmentRef']['name'])){
                $data['location'] = $results['Purchase']['DepartmentRef']['name'];
            }else{
                $data['location'] = "";
            }

            $data['transactions'] = [];
            $count_debits = count($results['Purchase']['Line']) - 1;
            if($count_debits > -1){
                for($i = 0; $i <= $count_debits; $i++) {
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
            CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/billpayment/".$id."?minorversion=14",
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
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = 1;
                }else{
                    $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                }
            }else{
                $data['voucher_no'] = "";
            }

            $data['voucher_date'] = $results['BillPayment']['TxnDate'];
            if(isset($results['BillPayment']['DocNumber'])){
                $data['reference_no'] = $results['BillPayment']['DocNumber'];
            }else{
                $data['reference_no'] = "";
            }
            $data['payee_name'] = $results['BillPayment']['VendorRef']['name'];
            $data['received_from'] = "";
            $data['cheque_no'] = "";
            $data['cheque_date'] = "";
            $data['location'] = "";

            $bill_id = $results['BillPayment']['Line'][0]['LinkedTxn'][0]['TxnId'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/bill/".$bill_id."?minorversion=14",
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

            $data['transactions'][0]['account_code_name'] = $results['BillPayment']['VendorRef']['name'];
            $data['transactions'][0]['memo'] = $bills['Bill']['APAccountRef']['name'];
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
