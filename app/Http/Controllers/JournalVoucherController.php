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

class JournalVoucherController extends Controller
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
                return redirect('tr-journal-voucher')->with('message','Date range should not greater than one month!');
            }

            $amount = $request->amount;
            $memo = $request->memo;

            $from_date = date('Y-m-d',strtotime($request->from_date));
            $to_date = date('Y-m-d',strtotime($request->to_date));
            
            $token = getToken();
            $index = -1;
            $data = [];

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
            CURLOPT_POSTFIELDS =>"SELECT * FROM journalentry WHERE TxnDate >= '$from_date' AND TxnDate <= '$to_date'",
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

                        $index = $index + 1;

                        if($memo != "") { 
                            if(!isset($results['QueryResponse']['JournalEntry'][$i]['PrivateNote'])) {
                                continue;
                            }
                            if(strpos(strtolower($results['QueryResponse']['JournalEntry'][$i]['PrivateNote']), strtolower($memo)) === FALSE){
                                continue;
                            }
                        }

                        $total_amount = 0;
                        $count_lines = count($results['QueryResponse']['JournalEntry'][$i]['Line']) - 1;
                        if($count_lines > -1){
                            for($j = 0; $j <= $count_lines; $j++) {
                                if($results['QueryResponse']['JournalEntry'][$i]['Line'][$j]['JournalEntryLineDetail']['PostingType'] == "Credit") {
                                    $total_amount = $total_amount + $results['QueryResponse']['JournalEntry'][$i]['Line'][$j]['Amount'];
                                }
                            }
                        }

                        //Filters
                        if($amount != "" && $total_amount != $amount) { continue; }
                        $data[$index]['TotalAmt'] = $total_amount;

                        $data[$index]['Id'] = $results['QueryResponse']['JournalEntry'][$i]['Id'];
                        $data[$index]['TxnDate'] = $results['QueryResponse']['JournalEntry'][$i]['TxnDate'];
                      
                        if(isset($results['QueryResponse']['JournalEntry'][$i]['PrivateNote'])){
                            $data[$index]['Memo'] = $results['QueryResponse']['JournalEntry'][$i]['PrivateNote'];
                        }else{
                            $data[$index]['Memo'] = "";
                        }
                    }
                }
            }
            return view('vouchers.journal',compact('data','from_date','to_date','amount','memo'));
        }
        
        else{
            $amount = "";
            $memo = "";
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data = [];
            return view('vouchers.journal',compact('data','from_date','to_date','amount','memo'));
        }
    }

    public function preview($print_status,$api_type,$id){
        $voucher_type = "Journal-Voucher";
        $data = $this->journal_voucher_print($api_type,$id);
        $voucher_formats = VoucherFormat::select('id','title','default')->where('company_id',Auth::user()->company_id)->where('type',$voucher_type)->get();
        $settings = Setting::where('company_id',Auth::user()->company_id)->first();
        $currencies = Currency::where('company_id',Auth::user()->company_id)->get();
        $defaults = Currency::where('company_id',Auth::user()->company_id)->where('default',1)->first();
        return view('vouchers.print_preview',compact('print_status','settings','currencies','data','voucher_type','api_type','voucher_formats','defaults'));
    }

    public function journal_voucher_print($api_type,$id){
        $company = Company::where('id',Auth::user()->company_id)->first();
        $token = getToken();
        $data = [];
        $settings = Setting::where('company_id',Auth::user()->company_id)->first(); 
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/journalentry/".$id."?minorversion=14",
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
            $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Journal-Voucher')->orderBy('created_at','desc')->first();
            if($latest_voucher == ""){
                $data['voucher_no'] = $settings->journal_voucher_start_from;
            }else{
                if($settings->journal_voucher_prefix == $latest_voucher->prefix && $settings->journal_voucher_suffix == $latest_voucher->suffix){
                    $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                }else{
                    $data['voucher_no'] = $settings->journal_voucher_start_from;
                }
            }
            $data['prefix'] = $settings->journal_voucher_prefix;
            $data['suffix'] = $settings->journal_voucher_suffix;
        }else{
            $data['voucher_no'] = "";
            $data['prefix'] = "";
            $data['suffix'] = "";
        }
        $data['id'] = $results['JournalEntry']['Id'];
        $data['voucher_date'] = $results['JournalEntry']['TxnDate'];
        if(isset($results['JournalEntry']['DocNumber'])){
            $data['reference_no'] = $results['JournalEntry']['DocNumber'];
        }else{
            $data['reference_no'] = "";
        }
        
        $data['payee_name'] = "";
        $data['received_from'] = "";
        $data['cheque_no'] = "";
        $data['cheque_date'] = "";
        $data['location'] = "";

        if(isset($results['JournalEntry']['PrivateNote'])){
            $data['memo'] = $results['JournalEntry']['PrivateNote'];
        }else{
            $data['memo'] = "";
        }
        $data['PaidFrom'] = "";
        $data['transactions'] = [];
        
        $count_debits = count($results['JournalEntry']['Line']) - 1;
        if($count_debits > -1){
            for($i = 0; $i <= $count_debits; $i++) {
                if(isset($results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['AccountRef']['name'])){
                    $data['transactions'][$i]['account_code_name'] = $results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['AccountRef']['name'];
                }
                else{
                    $data['transactions'][$i]['account_code_name'] = "";
                }
                if(isset($results['JournalEntry']['Line'][$i]['Description'])){
                    $data['transactions'][$i]['memo'] = $results['JournalEntry']['Line'][$i]['Description'];
                }else{
                    $data['transactions'][$i]['memo'] = "";
                }
                if(isset($results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['Entity']['EntityRef']['name'])){
                    $data['transactions'][$i]['customer_job_project_name'] = $results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['Entity']['EntityRef']['name'];
                }else{
                    $data['transactions'][$i]['customer_job_project_name'] = "";
                }
                if(isset($results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['ClassRef']['name'])){
                    $data['transactions'][$i]['class'] = $results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['ClassRef']['name'];
                }else{
                    $data['transactions'][$i]['class'] = "";
                }
                if($results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['PostingType'] == "Debit"){
                    $data['transactions'][$i]['debit'] = $results['JournalEntry']['Line'][$i]['Amount'];
                    $data['transactions'][$i]['credit'] = "";
                }else if($results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['PostingType'] == "Credit"){
                    $data['transactions'][$i]['debit'] = "";
                    $data['transactions'][$i]['credit'] = $results['JournalEntry']['Line'][$i]['Amount'];
                }

                if(isset($results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['DepartmentRef']['name'])){
                    $data['location'] = $data['location'].','.$results['JournalEntry']['Line'][$i]['JournalEntryLineDetail']['DepartmentRef']['name'];
                }
            }
            $data['location'] = trim($data['location'],",");
        }
        return $data; 
    }
}
