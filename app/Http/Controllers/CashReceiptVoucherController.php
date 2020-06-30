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

class CashReceiptVoucherController extends Controller
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
                return redirect('tr-cash-receipt-voucher')->with('message','Date range should not greater than one month!');
            }

            $type = $request->trx_type;
            $received_from = $request->received_from;
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
            CURLOPT_POSTFIELDS =>"SELECT * FROM Account WHERE AccountSubType = 'CashOnHand'",
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

            if(count($CashOnHandID) != 0) {
                // GET DATA FROM PURCHASE
                if($type == 'all' || $type == 'bank_deposit') {
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
                    CURLOPT_POSTFIELDS =>"SELECT * FROM Deposit WHERE TxnDate >= '$from_date' AND TxnDate <= '$to_date'",
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
                                if(in_array($results['QueryResponse']['Deposit'][$i]['DepositToAccountRef']['value'], $CashOnHandID)){
                                    //Filters
                                    if($received_from != "") {
                                        if(!isset($results['QueryResponse']['Deposit'][$i]['Line'][0]['DepositLineDetail']['Entity']['name'])) {
                                            continue;
                                        }
                                        if(strpos(strtolower($results['QueryResponse']['Deposit'][$i]['Line'][0]['DepositLineDetail']['Entity']['name']), strtolower($received_from)) === FALSE){
                                            continue;
                                        }
                                    }
                                    if($amount != "" && $results['QueryResponse']['Deposit'][$i]['TotalAmt'] != $amount) { continue; }
                                    if($memo != "") { 
                                        if(!isset($results['QueryResponse']['Deposit'][$i]['PrivateNote'])) {
                                            continue;
                                        }
                                        if(strpos(strtolower($results['QueryResponse']['Deposit'][$i]['PrivateNote']), strtolower($memo)) === FALSE){
                                            continue;
                                        }
                                    }

                                    $index = $index + 1;
                                    
                                    $data[$index]['Id'] = $results['QueryResponse']['Deposit'][$i]['Id'];
                                    $data[$index]['TxnDate'] = $results['QueryResponse']['Deposit'][$i]['TxnDate'];
                                    $data[$index]['TxnType'] = "Bank Deposit";
                                    $data[$index]['DocNumber'] = "";

                                    $line_count = count($results['QueryResponse']['Deposit'][$i]['Line']);
                                    if($line_count > 0){
                                        if(isset($results['QueryResponse']['Deposit'][$i]['Line'][0]['DepositLineDetail']['Entity']['name'])){
                                            $data[$index]['ReceivedFrom'] = $results['QueryResponse']['Deposit'][$i]['Line'][0]['DepositLineDetail']['Entity']['name'].' & more';
                                        }else{
                                            $data[$index]['ReceivedFrom'] = "";
                                        }
                                    }else{
                                        if(isset($results['QueryResponse']['Deposit'][$i]['Line'][0]['DepositLineDetail']['Entity']['name'])){
                                            $data[$index]['ReceivedFrom'] = $results['QueryResponse']['Deposit'][$i]['Line'][0]['DepositLineDetail']['Entity']['name'];
                                        }else{
                                            $data[$index]['ReceivedFrom'] = "";
                                        }
                                    }

                                    $data[$index]['DepositTo'] = $results['QueryResponse']['Deposit'][$i]['DepositToAccountRef']['name'];
                                    if(isset($results['QueryResponse']['Deposit'][$i]['PrivateNote'])){
                                        $data[$index]['Memo'] = $results['QueryResponse']['Deposit'][$i]['PrivateNote'];
                                    }else{
                                        $data[$index]['Memo'] = "";
                                    }
                                    $data[$index]['TotalAmt'] = $results['QueryResponse']['Deposit'][$i]['TotalAmt'];
                                }
                            }
                        }
                    }
                }

                // GET DATA FROM BILL PAYMENT
                if($type == 'pay_bills') {
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
                                        if($received_from != "") {
                                            if(!isset($results['QueryResponse']['BillPayment'][$i]['VendorRef']['name'])) {
                                                continue;
                                            }
                                            if(strpos(strtolower($results['QueryResponse']['BillPayment'][$i]['VendorRef']['name']), strtolower($received_from)) === FALSE){
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
            return view('vouchers.cash_receipt',compact('data','from_date','to_date','type','received_from','amount','memo'));
        }
        
        else{
            $type = "";
            $received_from = "";
            $amount = "";
            $memo = "";
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data = [];
            return view('vouchers.cash_receipt',compact('data','from_date','to_date','type','received_from','amount','memo'));
        }
    }

    public function preview($print_status,$api_type,$id){
        $voucher_type = "Cash-Receipt-Voucher";
        $data = $this->cash_receipt_voucher_print($api_type,$id);
        $voucher_formats = VoucherFormat::select('id','title','default')->where('company_id',Auth::user()->company_id)->where('type',$voucher_type)->get();
        $settings = Setting::where('company_id',Auth::user()->company_id)->first();
        $currencies = Currency::where('company_id',Auth::user()->company_id)->get();
        $defaults = Currency::where('company_id',Auth::user()->company_id)->where('default',1)->first();
        return view('vouchers.print_preview',compact('print_status','settings','currencies','data','voucher_type','api_type','voucher_formats','defaults'));
    }

    public function cash_receipt_voucher_print($api_type,$id){
        $company = Company::where('id',Auth::user()->company_id)->first();
        $token = getToken();
        $data = [];
        $settings = Setting::where('company_id',Auth::user()->company_id)->first(); 
        
        if($api_type == 'bank_deposit') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/deposit/".$id."?minorversion=14",
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
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Cash-Receipt-Voucher')->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = $settings->cash_receipt_voucher_start_from;
                }else{
                    if($settings->cash_receipt_voucher_prefix == $latest_voucher->prefix && $settings->cash_receipt_voucher_suffix == $latest_voucher->suffix){
                        $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                    }else{
                        $data['voucher_no'] = $settings->cash_receipt_voucher_start_from;
                    }
                }
                $data['prefix'] = $settings->cash_receipt_voucher_prefix;
                $data['suffix'] = $settings->cash_receipt_voucher_suffix;
            }else{
                $data['voucher_no'] = "";
                $data['prefix'] = "";
                $data['suffix'] = "";
            }
            $data['id'] = $results['Deposit']['Id'];
            $data['voucher_date'] = $results['Deposit']['TxnDate'];
            $data['reference_no'] = "";
            
            $line_count = count($results['Deposit']['Line']);
            if($line_count > 0){
                if(isset($results['Deposit']['Line'][0]['DepositLineDetail']['Entity']['name'])){
                    $data['received_from'] = $results['Deposit']['Line'][0]['DepositLineDetail']['Entity']['name'].' & more';
                }else{
                    $data['received_from'] = "";
                }
            }else{
                if(isset($results['Deposit']['Line'][0]['DepositLineDetail']['Entity']['name'])){
                    $data['received_from'] = $results['Deposit']['Line'][0]['DepositLineDetail']['Entity']['name'];
                }else{
                    $data['received_from'] = "";
                }
            }
            $data['deposit_to'] = $results['Deposit']['DepositToAccountRef']['name'];
            $data['cheque_no'] = "";
            $data['cheque_date'] = "";
            if(isset($results['Deposit']['DepartmentRef']['name'])){
                $data['location'] = $results['Deposit']['DepartmentRef']['name'];
            }else{
                $data['location'] = "";
            }
            if(isset($results['Deposit']['PrivateNote'])){
                $data['memo'] = $results['Deposit']['PrivateNote'];
            }else{
                $data['memo'] = "";
            }
            $data['transactions'] = [];
            $count_debits = count($results['Deposit']['Line']) - 1;
            if($count_debits > -1){
                $data['transactions'][0]['account_code_name'] = $results['Deposit']['DepositToAccountRef']['name'];
                if(isset($results['Deposit']['PrivateNote'])){
                    $data['transactions'][0]['memo'] = $results['Deposit']['PrivateNote'];
                }else{
                    $data['transactions'][0]['memo'] = "";
                }
                $data['transactions'][0]['customer_job_project_name'] = "";
                $data['transactions'][0]['class'] = "";
                $data['transactions'][0]['debit'] = $results['Deposit']['TotalAmt'];
                $data['transactions'][0]['credit'] = "";

                for($i = 0; $i <= $count_debits; $i++) {
                    $j = $i + 1;
                    $data['transactions'][$j]['account_code_name'] = $results['Deposit']['Line'][$i]['DepositLineDetail']['Entity']['name'];
                    if(isset($results['Deposit']['Line'][$i]['Description'])){
                        $data['transactions'][$j]['memo'] = $results['Deposit']['Line'][$i]['Description'];
                    }else{
                        $data['transactions'][$j]['memo'] = "";
                    }
                    $data['transactions'][$j]['customer_job_project_name'] = "";
                    if(isset($results['Deposit']['Line'][$i]['DepositLineDetail']['ClassRef']['name'])){
                        $data['transactions'][$j]['class'] = $results['Deposit']['Line'][$i]['DepositLineDetail']['ClassRef']['name'];
                    }else{
                        $data['transactions'][$j]['class'] = "";
                    }
                    $data['transactions'][$j]['debit'] = "";
                    $data['transactions'][$j]['credit'] = $results['Deposit']['Line'][$i]['Amount'];
                
                    if(isset($results['Deposit']['Line'][$i]['DepositLineDetail']['CheckNum']) && $results['Deposit']['Line'][$i]['DepositLineDetail']['CheckNum'] != ""){
                        $data['reference_no'] = $data['reference_no'].','.$results['Deposit']['Line'][$i]['DepositLineDetail']['CheckNum'];
                    }
                }
            }
            $data['reference_no'] = ltrim($data['reference_no'],',');
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
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Cash-Payment-Voucher')->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = $settings->cash_payment_voucher_start_from;
                }else{
                    if($settings->cash_payment_voucher_prefix == $latest_voucher->prefix && $settings->cash_payment_voucher_suffix == $latest_voucher->suffix){
                        $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                    }else{
                        $data['voucher_no'] = $settings->cash_payment_voucher_start_from;
                    }
                }
                $data['prefix'] = $settings->cash_payment_voucher_prefix;
                $data['suffix'] = $settings->cash_payment_voucher_suffix;
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
