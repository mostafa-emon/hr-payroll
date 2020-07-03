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
use App\VoucherDetail;

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
                $settings = Setting::where('company_id',Auth::user()->company_id)->first();

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

                                    $line_count_des = $line_count - 1;
                                    if($line_count_des > -1){
                                        for($j = 0; $j <= $line_count_des; $j++) {
                                            if(isset($results['QueryResponse']['Deposit'][$i]['Line'][$j]['DepositLineDetail']['CheckNum'])){
                                                $data[$index]['DocNumber'] = $data[$index]['DocNumber'].','.$results['QueryResponse']['Deposit'][$i]['Line'][$j]['DepositLineDetail']['CheckNum'];
                                            }
                                        }
                                    }
                                    if($data[$index]['DocNumber'] != "") {
                                        $data[$index]['DocNumber'] = ltrim($data[$index]['DocNumber'],',');
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

                if($type == 'all' || $type == 'receive_payment') {

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
                    CURLOPT_POSTFIELDS =>"SELECT * FROM payment WHERE TxnDate >= '$from_date' AND TxnDate <= '$to_date'",
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
                                if(in_array($results['QueryResponse']['Payment'][$i]['DepositToAccountRef']['value'], $CashOnHandID)){
                                    //Filters
                                    if($received_from != "") {
                                        if(!isset($results['QueryResponse']['Payment'][$i]['CustomerRef']['name'])) {
                                            continue;
                                        }
                                        if(strpos(strtolower($results['QueryResponse']['Payment'][$i]['CustomerRef']['name']), strtolower($received_from)) === FALSE){
                                            continue;
                                        }
                                    }
                                    if($amount != "" && $results['QueryResponse']['Payment'][$i]['TotalAmt'] != $amount) { continue; }
                                    if($memo != "") { 
                                        if(!isset($results['QueryResponse']['Payment'][$i]['PrivateNote'])) {
                                            continue;
                                        }
                                        if(strpos(strtolower($results['QueryResponse']['Payment'][$i]['PrivateNote']), strtolower($memo)) === FALSE){
                                            continue;
                                        }
                                    }

                                    $index = $index + 1;
                                    
                                    $data[$index]['Id'] = $results['QueryResponse']['Payment'][$i]['Id'];
                                    $data[$index]['TxnDate'] = $results['QueryResponse']['Payment'][$i]['TxnDate'];
                                    $data[$index]['TxnType'] = "Receive Payment";
                                    if(isset($results['QueryResponse']['Payment'][$i]['PaymentRefNum'])){
                                        $data[$index]['DocNumber'] = $results['QueryResponse']['Payment'][$i]['PaymentRefNum'];
                                    }else{
                                        $data[$index]['DocNumber'] = "";
                                    }

                                    if(isset($results['QueryResponse']['Payment'][$i]['CustomerRef']['name'])){
                                        $data[$index]['ReceivedFrom'] = $results['QueryResponse']['Payment'][$i]['CustomerRef']['name'];
                                    }else{
                                        $data[$index]['ReceivedFrom'] = "";
                                    }

                                    $curl = curl_init();
                                    curl_setopt_array($curl, array(
                                    CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/account/".$results['QueryResponse']['Payment'][$i]['DepositToAccountRef']['value']."?minorversion=14",
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

                                    $account = json_decode($response, true);
                                    if(isset($account['Account']['AcctNum'])) {
                                        $data[$index]['DepositTo'] = $account['Account']['AcctNum'].' '.$account['Account']['Name'];
                                    }else  {
                                        $data[$index]['DepositTo'] = $account['Account']['Name'];
                                    }
                                    if(isset($results['QueryResponse']['Payment'][$i]['PrivateNote'])){
                                        $data[$index]['Memo'] = $results['QueryResponse']['Payment'][$i]['PrivateNote'];
                                    }else{
                                        $data[$index]['Memo'] = "";
                                    }
                                    $data[$index]['TotalAmt'] = $results['QueryResponse']['Payment'][$i]['TotalAmt'];
                                }
                            }
                        }
                    }
                }
            }

            if($settings->cash_receipt_voucher_sales_receipt == 1 && ($type == 'all' || $type == 'sales_receipt')) {

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
                CURLOPT_POSTFIELDS =>"SELECT * FROM SalesReceipt WHERE TxnDate >= '$from_date' AND TxnDate <= '$to_date'",
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
                            if(in_array($results['QueryResponse']['SalesReceipt'][$i]['DepositToAccountRef']['value'], $CashOnHandID)){
                                //Filters
                                if($received_from != "") {
                                    if(!isset($results['QueryResponse']['SalesReceipt'][$i]['CustomerRef']['name'])) {
                                        continue;
                                    }
                                    if(strpos(strtolower($results['QueryResponse']['SalesReceipt'][$i]['CustomerRef']['name']), strtolower($received_from)) === FALSE){
                                        continue;
                                    }
                                }
                                if($amount != "" && $results['QueryResponse']['SalesReceipt'][$i]['TotalAmt'] != $amount) { continue; }
                                if($memo != "") { 
                                    if(!isset($results['QueryResponse']['SalesReceipt'][$i]['PrivateNote'])) {
                                        continue;
                                    }
                                    if(strpos(strtolower($results['QueryResponse']['SalesReceipt'][$i]['PrivateNote']), strtolower($memo)) === FALSE){
                                        continue;
                                    }
                                }

                                $index = $index + 1;
                                
                                $data[$index]['Id'] = $results['QueryResponse']['SalesReceipt'][$i]['Id'];
                                $data[$index]['TxnDate'] = $results['QueryResponse']['SalesReceipt'][$i]['TxnDate'];
                                $data[$index]['TxnType'] = "Sales Receipt";
                                if(isset($results['QueryResponse']['SalesReceipt'][$i]['PaymentRefNum'])){
                                    $data[$index]['DocNumber'] = $results['QueryResponse']['SalesReceipt'][$i]['PaymentRefNum'];
                                }else{
                                    $data[$index]['DocNumber'] = "";
                                }

                                if(isset($results['QueryResponse']['SalesReceipt'][$i]['CustomerRef']['name'])){
                                    $data[$index]['ReceivedFrom'] = $results['QueryResponse']['SalesReceipt'][$i]['CustomerRef']['name'];
                                }else{
                                    $data[$index]['ReceivedFrom'] = "";
                                }

                                $data[$index]['DepositTo'] = $results['QueryResponse']['SalesReceipt'][$i]['DepositToAccountRef']['name'];

                                if(isset($results['QueryResponse']['SalesReceipt'][$i]['PrivateNote'])){
                                    $data[$index]['Memo'] = $results['QueryResponse']['SalesReceipt'][$i]['PrivateNote'];
                                }else{
                                    $data[$index]['Memo'] = "";
                                }
                                $data[$index]['TotalAmt'] = $results['QueryResponse']['SalesReceipt'][$i]['TotalAmt'];
                            }
                        }
                    }
                }
            }
            
            return view('vouchers.cash_receipt',compact('settings','data','from_date','to_date','type','received_from','amount','memo'));
        }
        
        else{
            $type = "";
            $received_from = "";
            $amount = "";
            $memo = "";
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data = [];
            $settings = Setting::where('company_id',Auth::user()->company_id)->first();
            return view('vouchers.cash_receipt',compact('settings','data','from_date','to_date','type','received_from','amount','memo'));
        }
    }

    public function preview($print_status,$api_type,$id){
        if(roles() != "" && !in_array(56, json_decode(roles(),false))){
            return redirect('404');
        }
        $voucher_type = "Cash-Receipt-Voucher";
        if($print_status == 'printed') {
            $data = Voucher::where('type','Cash-Receipt-Voucher')->where('api_type',$api_type)->where('document_id',$id)->first();
            $data['transactions'] = VoucherDetail::where('voucher_id',$data->id)->get();
        }
        else {
            $data = $this->cash_receipt_voucher_print($api_type,$id);
        }
        
        $company = Company::where('id',Auth::user()->company_id)->first();
        $token = getToken();

        if($api_type == "receive_payment") {
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
            CURLOPT_POSTFIELDS =>"SELECT * FROM Account WHERE AccountSubType = 'AccountsReceivable' ORDERBY Id",
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

            $receivable_accounts = [];
            $resultCount = $accounts['QueryResponse']['maxResults'] - 1;
            if($resultCount > -1){
                for($i = 0; $i <= $resultCount; $i++) {
                    $receivable_accounts[$i]['Id'] = $accounts['QueryResponse']['Account'][$i]['Id'];
                    $receivable_accounts[$i]['Name'] = $accounts['QueryResponse']['Account'][$i]['FullyQualifiedName'];
                }
            }

        }else{
            $receivable_accounts = [];
        }
        $voucher_formats = VoucherFormat::select('id','title','default')->where('company_id',Auth::user()->company_id)->where('type',$voucher_type)->get();
        $settings = Setting::where('company_id',Auth::user()->company_id)->first();
        $currencies = Currency::where('company_id',Auth::user()->company_id)->get();
        $defaults = Currency::where('company_id',Auth::user()->company_id)->where('default',1)->first();
        return view('vouchers.print_preview',compact('receivable_accounts','print_status','settings','currencies','data','voucher_type','api_type','voucher_formats','defaults'));
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
        
        else if($api_type == 'receive_payment') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/payment/".$id."?minorversion=14",
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
            $data['id'] = $results['Payment']['Id'];
            $data['voucher_date'] = $results['Payment']['TxnDate'];
            if(isset($results['Payment']['PaymentRefNum'])) {
                $data['reference_no'] = $results['Payment']['PaymentRefNum'];
            }else{
                $data['reference_no'] = "";
            }
            
            if(isset($results['Payment']['CustomerRef']['name'])) {
                $data['received_from'] = $results['Payment']['CustomerRef']['name'];
            }else {
                $data['received_from'] = "";
            }
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/account/".$results['Payment']['DepositToAccountRef']['value']."?minorversion=14",
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

            $account = json_decode($response, true);
            
            if(isset($account['Account']['AcctNum'])) {
                $data['deposit_to'] = $account['Account']['AcctNum'].' '.$account['Account']['Name'];
            }else  {
                $data['deposit_to'] = $account['Account']['Name'];
            }

            $data['cheque_no'] = "";
            $data['cheque_date'] = "";

            $data['location'] = "";
            if(isset($results['Payment']['PrivateNote'])){
                $data['memo'] = $results['Payment']['PrivateNote'];
            }else{
                $data['memo'] = "";
            }
            $data['transactions'] = [];
            
            $data['transactions'][0]['account_code_name'] = $data['deposit_to'];
            if(isset($results['Payment']['PrivateNote'])){
                $data['transactions'][0]['memo'] = $results['Payment']['PrivateNote'];
            }else{
                $data['transactions'][0]['memo'] = "";
            }
            $data['transactions'][0]['customer_job_project_name'] = "";
            $data['transactions'][0]['class'] = "";
            $data['transactions'][0]['debit'] = $results['Payment']['TotalAmt'];
            $data['transactions'][0]['credit'] = "";

            $data['transactions'][1]['account_code_name'] = "";
            if(isset($results['Payment']['PrivateNote'])){
                $data['transactions'][1]['memo'] = $results['Payment']['PrivateNote'];
            }else{
                $data['transactions'][1]['memo'] = "";
            }
            $data['transactions'][1]['customer_job_project_name'] = "";
            $data['transactions'][1]['class'] = "";
            $data['transactions'][1]['debit'] = "";
            $data['transactions'][1]['credit'] = $results['Payment']['TotalAmt'];
            
            return $data; 
        }

        else if($api_type == 'sales_receipt') {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/salesreceipt/".$id."?minorversion=14",
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
            $data['id'] = $results['SalesReceipt']['Id'];
            $data['voucher_date'] = $results['SalesReceipt']['TxnDate'];
            if(isset($results['SalesReceipt']['PaymentRefNum'])) {
                $data['reference_no'] = $results['SalesReceipt']['PaymentRefNum'];
            }else{
                $data['reference_no'] = "";
            }
            
            if(isset($results['SalesReceipt']['CustomerRef']['name'])) {
                $data['received_from'] = $results['SalesReceipt']['CustomerRef']['name'];
            }else {
                $data['received_from'] = "";
            }

            if(isset($results['SalesReceipt']['DepositToAccountRef']['name'])) {
                $data['deposit_to'] = $results['SalesReceipt']['DepositToAccountRef']['name'];
            }else {
                $data['deposit_to'] = "";
            }

            $data['cheque_no'] = "";
            $data['cheque_date'] = "";

            if(isset($results['SalesReceipt']['DepartmentRef']['name'])) {
                $data['location'] = $results['SalesReceipt']['DepartmentRef']['name'];
            }else {
                $data['location'] = "";
            }

            if(isset($results['SalesReceipt']['PrivateNote'])){
                $data['memo'] = $results['SalesReceipt']['PrivateNote'];
            }else{
                $data['memo'] = "";
            }
            $data['transactions'] = [];

            $count_debits = count($results['SalesReceipt']['Line']) - 2;
            if($count_debits > -1){
                $data['transactions'][0]['account_code_name'] = $data['deposit_to'];
                if(isset($results['SalesReceipt']['PrivateNote'])){
                    $data['transactions'][0]['memo'] = $results['SalesReceipt']['PrivateNote'];
                }else{
                    $data['transactions'][0]['memo'] = "";
                }
                $data['transactions'][0]['customer_job_project_name'] = "";
                $data['transactions'][0]['class'] = "";
                $data['transactions'][0]['debit'] = $results['SalesReceipt']['TotalAmt'];
                $data['transactions'][0]['credit'] = "";

                for($i = 0; $i <= $count_debits; $i++) {
                    $j = $i + 1;
                    $data['transactions'][$j]['account_code_name'] = $results['SalesReceipt']['Line'][$i]['SalesItemLineDetail']['ItemAccountRef']['name'];
                    if(isset($results['SalesReceipt']['Line'][$i]['Description'])){
                        $data['transactions'][$j]['memo'] = $results['SalesReceipt']['Line'][$i]['Description'];
                    }else{
                        $data['transactions'][$j]['memo'] = "";
                    }
                    $data['transactions'][$j]['customer_job_project_name'] = "";
                    if(isset($results['SalesReceipt']['Line'][$i]['SalesItemLineDetail']['ClassRef']['name'])){
                        $data['transactions'][$j]['class'] = $results['SalesReceipt']['Line'][$i]['SalesItemLineDetail']['ClassRef']['name'];
                    }else{
                        $data['transactions'][$j]['class'] = "";
                    }
                    $data['transactions'][$j]['debit'] = "";
                    $data['transactions'][$j]['credit'] = $results['SalesReceipt']['Line'][$i]['Amount'];
                }
            }
            
            return $data; 
        }
    }
}
