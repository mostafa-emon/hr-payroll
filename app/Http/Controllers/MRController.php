<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyReceipt;
use App\SiteOffice;
use App\Customer;
use App\Currency;
use App\PaymentMethod;
use App\Setting;
use App\Voucher;
use App\Company;
use Auth;
use App\Mail\SendMR;
use Illuminate\Support\Facades\Mail;
use PDF;
use Config;
use App\QuickBook;
use DateTime;

class MRController extends Controller
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
                return redirect('tr-bank-receipt-voucher')->with('message','Date range should not greater than one month!');
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

            // GET BANK ACCOUNTS
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
                    if($accounts['QueryResponse']['Account'][$i]['AccountSubType'] == "CashOnHand"
                     || $accounts['QueryResponse']['Account'][$i]['AccountSubType'] == "Checking"
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
                                            $data[$index]['DocNumber'] = $data[$index]['DocNumber'].','.$results['QueryResponse']['Deposit'][$i]['Line'][$j]['DepositLineDetail']['CheckNum'];
                                        }
                                    }
                                    $data[$index]['DocNumber'] = ltrim($data[$index]['DocNumber'],',');

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
            
            return view('mr.index',compact('settings','data','from_date','to_date','type','received_from','amount','memo'));
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
            return view('mr.index',compact('settings','data','from_date','to_date','type','received_from','amount','memo'));
        }
    }

    public function preview($print_status,$api_type,$id){
        $voucher_type = "Bank-Receipt-Voucher";
        $data = $this->money_receipt_print($api_type,$id);
        
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
        
        $settings = Setting::where('company_id',Auth::user()->company_id)->first();
        $currencies = Currency::where('company_id',Auth::user()->company_id)->get();
        $defaults = Currency::where('company_id',Auth::user()->company_id)->where('default',1)->first();
        $payment_methods = PaymentMethod::where('company_id',Auth::user()->company_id)->get();
        $document_id = $id;
        return view('mr.add',compact('receivable_accounts','print_status','settings','currencies','data','voucher_type','api_type','document_id','defaults','payment_methods'));
    }

    public function money_receipt_print($api_type,$id){
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
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Bank-Receipt-Voucher')->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = $settings->bank_receipt_voucher_start_from;
                }else{
                    if($settings->bank_receipt_voucher_prefix == $latest_voucher->prefix && $settings->bank_receipt_voucher_suffix == $latest_voucher->suffix){
                        $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                    }else{
                        $data['voucher_no'] = $settings->bank_receipt_voucher_start_from;
                    }
                }
                $data['prefix'] = $settings->bank_receipt_voucher_prefix;
                $data['suffix'] = $settings->bank_receipt_voucher_suffix;
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
                    $customer_id = $results['Deposit']['Line'][0]['DepositLineDetail']['Entity']['value'];
                    $entity_type = $results['Deposit']['Line'][0]['DepositLineDetail']['Entity']['type'];

                    if($entity_type == "CUSTOMER") {
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/customer/".$customer_id."?minorversion=14",
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

                        $cusDetail = json_decode($response, true);

                        $address = "";
                        if(isset($cusDetail['Customer']['BillAddr']['Line1'])) {
                            $address = $address.$cusDetail['Customer']['BillAddr']['Line1'];
                        }
                        if(isset($cusDetail['Customer']['BillAddr']['City'])) {
                            $address = $address.', '.$cusDetail['Customer']['BillAddr']['City'];
                        }
                        if(isset($cusDetail['Customer']['BillAddr']['PostalCode'])) {
                            $address = $address.', '.$cusDetail['Customer']['BillAddr']['PostalCode'];
                        }
                        if(isset($cusDetail['Customer']['BillAddr']['Country'])) {
                            $address = $address.', '.$cusDetail['Customer']['BillAddr']['Country'];
                        }
                        $address = ltrim($address,', ');
                        $data['customer_address'] = $address;
                    }
                    else {
                        $data['customer_address'] = "";
                    }
                }else{
                    $data['received_from'] = "";
                    $data['customer_address'] = "";
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

            $data['TotalAmt'] = $results['Deposit']['TotalAmt'];

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
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Bank-Receipt-Voucher')->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = $settings->bank_receipt_voucher_start_from;
                }else{
                    if($settings->bank_receipt_voucher_prefix == $latest_voucher->prefix && $settings->bank_receipt_voucher_suffix == $latest_voucher->suffix){
                        $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                    }else{
                        $data['voucher_no'] = $settings->bank_receipt_voucher_start_from;
                    }
                }
                $data['prefix'] = $settings->bank_receipt_voucher_prefix;
                $data['suffix'] = $settings->bank_receipt_voucher_suffix;
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
                $customer_id = $results['Payment']['CustomerRef']['value'];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/customer/".$customer_id."?minorversion=14",
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

                $cusDetail = json_decode($response, true);

                $address = "";
                if(isset($cusDetail['Customer']['BillAddr']['Line1'])) {
                    $address = $address.$cusDetail['Customer']['BillAddr']['Line1'];
                }
                if(isset($cusDetail['Customer']['BillAddr']['City'])) {
                    $address = $address.', '.$cusDetail['Customer']['BillAddr']['City'];
                }
                if(isset($cusDetail['Customer']['BillAddr']['PostalCode'])) {
                    $address = $address.', '.$cusDetail['Customer']['BillAddr']['PostalCode'];
                }
                if(isset($cusDetail['Customer']['BillAddr']['Country'])) {
                    $address = $address.', '.$cusDetail['Customer']['BillAddr']['Country'];
                }
                $address = ltrim($address,', ');
                $data['customer_address'] = $address;
            }else {
                $data['customer_address'] = "";
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

            $data['TotalAmt'] = $results['Payment']['TotalAmt'];

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
                $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Bank-Receipt-Voucher')->orderBy('created_at','desc')->first();
                if($latest_voucher == ""){
                    $data['voucher_no'] = $settings->bank_receipt_voucher_start_from;
                }else{
                    if($settings->bank_receipt_voucher_prefix == $latest_voucher->prefix && $settings->bank_receipt_voucher_suffix == $latest_voucher->suffix){
                        $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                    }else{
                        $data['voucher_no'] = $settings->bank_receipt_voucher_start_from;
                    }
                }
                $data['prefix'] = $settings->bank_receipt_voucher_prefix;
                $data['suffix'] = $settings->bank_receipt_voucher_suffix;
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
                $customer_id = $results['SalesReceipt']['CustomerRef']['value'];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/customer/".$customer_id."?minorversion=14",
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

                $cusDetail = json_decode($response, true);

                $address = "";
                if(isset($cusDetail['Customer']['BillAddr']['Line1'])) {
                    $address = $address.$cusDetail['Customer']['BillAddr']['Line1'];
                }
                if(isset($cusDetail['Customer']['BillAddr']['City'])) {
                    $address = $address.', '.$cusDetail['Customer']['BillAddr']['City'];
                }
                if(isset($cusDetail['Customer']['BillAddr']['PostalCode'])) {
                    $address = $address.', '.$cusDetail['Customer']['BillAddr']['PostalCode'];
                }
                if(isset($cusDetail['Customer']['BillAddr']['Country'])) {
                    $address = $address.', '.$cusDetail['Customer']['BillAddr']['Country'];
                }
                $address = ltrim($address,', ');
                $data['customer_address'] = $address;
            }else {
                $data['received_from'] = "";
                $data['customer_address'] = "";
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

            $data['TotalAmt'] = $results['SalesReceipt']['TotalAmt'];

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

    public function add(Request $request) {
        $setting = Setting::where('company_id',Auth::user()->company_id)->first();
        
        if($setting->mr_number == "auto"){
            $last_invoice = MoneyReceipt::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->first();
            if(!isset($last_invoice->invoice_no)){
                $invoice_no = $setting->mr_start_from;
            } else{
                if($last_invoice->mr_prefix == $setting->mr_prefix && $last_invoice->mr_suffix == $setting->mr_suffix) {
                    $invoice_no = $last_invoice->invoice_no + 1;
                }else{
                    $invoice_no = $setting->mr_start_from;
                }
            }
        }else{
            $invoice_no = $request->invoice_no;
        }
        
        list($currency_full_name,$currency_fraction_name) = explode("_",$request->currency);
        
        $mr = new MoneyReceipt();
        $mr->invoice_no             = $invoice_no;
        $mr->customer_name          = $request->customer_name;
        $mr->customer_address       = $request->customer_address;
        $mr->amount                 = $request->amount;
        $mr->currency               = $currency_full_name;
        $mr->amount_in_word         = $request->amount_in_words;
        $mr->payment_method         = $request->payment_method;
        $mr->cheque_no              = $request->cheque_no;
        $mr->cheque_date            = date('Y-m-d',strtotime($request->cheque_date));
        $mr->bank_name              = $request->bank_name;
        $mr->purpose                = $request->purpose;
        $mr->mr_prefix              = $setting->mr_prefix;
        $mr->mr_suffix              = $setting->mr_suffix;
        $mr->api_type               = $request->api_type;
        $mr->document_id            = $request->document_id;
        $mr->status                 = 1;
        $mr->company_id             = Auth::user()->company_id;
        $mr->save();

        $company = Company::where('id',Auth::user()->company_id)->first();
        if($setting->mr_size == "full_page"){
            return view('mr.print_full', ['transaction'=>$mr, 'company' => $company, 'setting' => $setting, 'status' => 'approved']);
        }else{
            return view('mr.print_half', ['transaction'=>$mr, 'company' => $company, 'setting' => $setting, 'status' => 'approved']);
        }
    }

    public function sendmail(){
        Config::set('mail.driver', 'smtp');
        Config::set('mail.host', 'smtp.gmail.com');
        Config::set('mail.port', '587');
        Config::set('mail.username', 'mostafa.shopinvento@gmail.com');
        Config::set('mail.password', 'A1c3E5g7');
        Config::set('mail.encryption', 'tls');

        Config::set('mail.from.address', 'mostafa.shopinvento@gmail.com');
        Config::set('mail.from.name', 'ShopMamun');
        
        $data["email"] ='mostafaemon.info@gmail.com';
        $data["client_name"]='Mostafa Emon';
        $data["subject"]='This is test email';

        $pdf = PDF::loadView('email.mr', $data);

        try{
            Mail::send('email.mr', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"])
                ->attachData($pdf->output(), "invoice.pdf");
            });
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";

        }else{

           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        return response()->json(compact('this'));
    }

    public function void($api_type,$document_id){
        MoneyReceipt::where('api_type' , $api_type)
        ->where('document_id',$document_id)
        ->update(['status' => 0]);

        return redirect('create-mr')->with('message','Successfully Void!');
    }

    public function reprint($api_type,$document_id){
        $setting = Setting::where('company_id',Auth::user()->company_id)->first();
        $company = Company::where('id',Auth::user()->company_id)->first();
        $mr = MoneyReceipt::where('api_type',$api_type)->where('document_id',$document_id)->where('status',1)->first();
        if($setting->mr_size == "full_page"){
            return view('mr.print_full', ['transaction'=>$mr, 'company' => $company, 'setting' => $setting, 'status' => 'approved']);
        }else{
            return view('mr.print_half', ['transaction'=>$mr, 'company' => $company, 'setting' => $setting, 'status' => 'approved']);
        }
    }
}
