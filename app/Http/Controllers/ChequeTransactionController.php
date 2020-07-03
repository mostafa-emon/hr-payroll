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
use App\Printer;
use App\Bank;
use App\BankAccount;
use App\ChequeLayout;
use App\ChequeBook;
use App\Cheque;
use App\ChequeTransaction;

class ChequeTransactionController extends Controller
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
                return redirect('tr-bank-payment-voucher')->with('message','Date range should not greater than one month!');
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
            return view('cheque_transactions.index',compact('data','from_date','to_date','type','payee_name','amount','memo'));
        }
        
        else{
            $type = "";
            $payee_name = "";
            $amount = "";
            $memo = "";
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data = [];
            return view('cheque_transactions.index',compact('data','from_date','to_date','type','payee_name','amount','memo'));
        }
    }

    public function add($bank_id,$print_status,$api_type,$document_id,$payee_name,$txn_date,$amount,Request $request){
        if(roles() != "" && !in_array(36, json_decode(roles(),false))){
            return redirect('404');
        }
        $setting   = Setting::where('company_id',Auth::user()->company_id)->first();
        $printers   = Printer::where('company_id',Auth::user()->company_id)->orderby('id','desc')->get();
        $banks      = Bank::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $accounts   = [];
        $layout     = "";
        
        if($bank_id != "" && $bank_id != null) {
            $accounts = BankAccount::where('bank_id',$bank_id)->get();
            $layout = ChequeLayout::where('bank_id',$bank_id)->first();
        }

        return view('cheque_transactions.print_preview', ['banks' => $banks, 'printers' => $printers, 'bank_id' => $bank_id, 'accounts' => $accounts, 'layout' => $layout, 'setting' => $setting, 'print_status' => $print_status, 'api_type' => $api_type, 'document_id' => $document_id, 'payee_name' => $payee_name, 'txn_date' => $txn_date, 'amount' => $amount]);
    }

    public function save_cheque(Request $request) {
        $trx = ChequeTransaction::where('api_type',$request->api_type)
                        ->where('document_id',$request->document_id)
                        ->where('company_id',Auth::user()->company_id)
                        ->where('status',1)
                        ->first();
        if($trx != "") {
            ChequeTransaction::where('id',$trx->id)->delete();
        }

        $cheque_transaction = new ChequeTransaction();

        $cheque_transaction->bank_name      = Bank::where('id',$request->bank_name)->value('name');
        $cheque_transaction->ac_number      = BankAccount::where('id',$request->ac_number)->value('ac_number');
        $cheque_transaction->book_no        = ChequeBook::where('id',$request->book_no)->value('book_no');
        $cheque_transaction->cheque_no      = $request->cheque_no;
        $cheque_transaction->date           = date('Y-m-d',strtotime($request->date_field));
        $cheque_transaction->cheque_name    = $request->payee_name;
        $cheque_transaction->amount         = $request->inputAmount;
        $cheque_transaction->amount_in_word_line_1 = $request->amount_in_word_line_1_input;
        $cheque_transaction->amount_in_word_line_2 = $request->amount_in_word_line_2_input;

        if($request->ac_payee_only == 1) {
            $cheque_transaction->ac_payee_only       = 1;
        }else { $cheque_transaction->ac_payee_only   = 0; }
        
        $cheque_transaction->status         = 0;
        $cheque_transaction->company_id     = Auth::user()->company_id;

        $cheque_transaction->document_id    = $request->document_id;
        $cheque_transaction->api_type       = $request->api_type;
        $cheque_transaction->status         = 1;
        $cheque_transaction->save();

        $cheque = Cheque::where('cheque_no',$request->cheque_no)->where('company_id',Auth::user()->company_id)->first();
        $cheque->status = 1;
        $cheque->save();
        
        $layout = ChequeLayout::where('id',$request->layout_id)->first();

        return view('cheque_transactions.print',['transaction' => $cheque_transaction, 'layout' => $layout]);
    }

    public function void($api_type,$document_id){
        ChequeTransaction::where('api_type' , $api_type)
        ->where('document_id',$document_id)
        ->update(['status' => 0]);

        return redirect('create-cheque')->with('message','Successfully Void!');
    }

    public function get_cheque_book_by_account($account_id){
        $books = ChequeBook::where('account_id',$account_id)->get();
        foreach($books as $book){
            echo '<option value="'.$book->id.'">'.$book->book_no.'</option>';
        }
    }

    public function get_cheques_by_book($book_id){
        $cheques = Cheque::where('cheque_book_id',$book_id)->where('status',0)->get();
        foreach($cheques as $cheque){
            echo '<option value="'.$cheque->cheque_no.'">'.$cheque->cheque_no.'</option>';
        }
    }

    public function get_currency_by_account($account_id){
        $account = BankAccount::where('id',$account_id)->first();
        $currency = Currency::where('id',$account->currency_id)->first();
        echo json_encode($currency);
    }

    public function reprint($api_type,$document_id){
        if(roles() != "" && !in_array(36, json_decode(roles(),false))){
            return redirect('404');
        }
        $cheque_transaction = ChequeTransaction::where('document_id',$document_id)->where('status',1)->first();
        $bank_id = Bank::where('name',$cheque_transaction->bank_name)->where('company_id',Auth::user()->company_id)->value('id');
        $layout = ChequeLayout::where('bank_id',$bank_id)->first();
        return view('cheque_transactions.print',['transaction' => $cheque_transaction, 'layout' => $layout]);
    }
}
