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

class MRController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
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

    public function create_mr(){
        return view('vouchers.create_mr');
    }

    public function create_cheque(){
        return view('vouchers.create_cheque');
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
}
