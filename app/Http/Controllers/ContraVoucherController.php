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

class ContraVoucherController extends Controller
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
                return redirect('tr-contra-voucher')->with('message','Date range should not greater than one month!');
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
            CURLOPT_POSTFIELDS =>"SELECT * FROM Transfer WHERE TxnDate >= '$from_date' AND TxnDate <= '$to_date'",
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
                        //Filters
                        if($amount != "" && $results['QueryResponse']['Transfer'][$i]['Amount'] != $amount) { continue; }
                        if($memo != "") { 
                            if(!isset($results['QueryResponse']['Transfer'][$i]['PrivateNote'])) {
                                continue;
                            }
                            if(strpos(strtolower($results['QueryResponse']['Transfer'][$i]['PrivateNote']), strtolower($memo)) === FALSE){
                                continue;
                            }
                        }
                        $index = $index + 1;
                        
                        $data[$index]['Id'] = $results['QueryResponse']['Transfer'][$i]['Id'];
                        $data[$index]['TxnDate'] = $results['QueryResponse']['Transfer'][$i]['TxnDate'];
                        $data[$index]['TotalAmt'] = $results['QueryResponse']['Transfer'][$i]['Amount'];
                        $data[$index]['From'] = $results['QueryResponse']['Transfer'][$i]['FromAccountRef']['name'];
                        $data[$index]['To'] = $results['QueryResponse']['Transfer'][$i]['ToAccountRef']['name'];

                        if(isset($results['QueryResponse']['Transfer'][$i]['PrivateNote'])){
                            $data[$index]['Memo'] = $results['QueryResponse']['Transfer'][$i]['PrivateNote'];
                        }else{
                            $data[$index]['Memo'] = "";
                        }
                    }
                }
            }
            return view('vouchers.contra',compact('data','from_date','to_date','amount','memo'));
        }
        
        else{
            $amount = "";
            $memo = "";
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $data = [];
            return view('vouchers.contra',compact('data','from_date','to_date','amount','memo'));
        }
    }

    public function preview($print_status,$api_type,$id){
        $voucher_type = "Contra-Voucher";
        $data = $this->contra_voucher_print($api_type,$id);
        $voucher_formats = VoucherFormat::select('id','title','default')->where('company_id',Auth::user()->company_id)->where('type',$voucher_type)->get();
        $settings = Setting::where('company_id',Auth::user()->company_id)->first();
        $currencies = Currency::where('company_id',Auth::user()->company_id)->get();
        $defaults = Currency::where('company_id',Auth::user()->company_id)->where('default',1)->first();
        return view('vouchers.print_preview',compact('print_status','settings','currencies','data','voucher_type','api_type','voucher_formats','defaults'));
    }

    public function contra_voucher_print($api_type,$id){
        $company = Company::where('id',Auth::user()->company_id)->first();
        $token = getToken();
        $data = [];
        $settings = Setting::where('company_id',Auth::user()->company_id)->first(); 
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $company->qb_environment."/v3/company/".$company->qb_company_id."/transfer/".$id."?minorversion=14",
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
            $latest_voucher = Voucher::where('company_id',Auth::User()->company_id)->where('type','Contra-Voucher')->orderBy('created_at','desc')->first();
            if($latest_voucher == ""){
                $data['voucher_no'] = $settings->contra_voucher_start_from;
            }else{
                if($settings->contra_voucher_prefix == $latest_voucher->prefix && $settings->contra_voucher_suffix == $latest_voucher->suffix){
                    $data['voucher_no'] = $latest_voucher->voucher_no + 1;
                }else{
                    $data['voucher_no'] = $settings->contra_voucher_start_from;
                }
            }
            $data['prefix'] = $settings->contra_voucher_prefix;
            $data['suffix'] = $settings->contra_voucher_suffix;
        }else{
            $data['voucher_no'] = "";
            $data['prefix'] = "";
            $data['suffix'] = "";
        }
        $data['id'] = $results['Transfer']['Id'];
        $data['voucher_date'] = $results['Transfer']['TxnDate'];
        $data['reference_no'] = "";
        $data['payee_name'] = "";
        $data['received_from'] = "";
        $data['cheque_no'] = "";
        $data['cheque_date'] = "";
        $data['location'] = "";
        if(isset($results['Transfer']['PrivateNote'])){
            $data['memo'] = $results['Transfer']['PrivateNote'];
        }else{
            $data['memo'] = "";
        }
        $data['PaidFrom'] = "";
        $data['transactions'] = [];

        $data['transactions'][0]['account_code_name'] = $results['Transfer']['ToAccountRef']['name'];
        if(isset($results['Transfer']['PrivateNote'])){
            $data['transactions'][0]['memo'] = $results['Transfer']['PrivateNote'];
        }else{
            $data['transactions'][0]['memo'] = "";
        }
        $data['transactions'][0]['customer_job_project_name'] = "";
        $data['transactions'][0]['class'] = "";
        $data['transactions'][0]['debit'] = $results['Transfer']['Amount'];
        $data['transactions'][0]['credit'] = "";

        $data['transactions'][1]['account_code_name'] = $results['Transfer']['FromAccountRef']['name'];
        if(isset($results['Transfer']['PrivateNote'])){
            $data['transactions'][1]['memo'] = $results['Transfer']['PrivateNote'];
        }else{
            $data['transactions'][1]['memo'] = "";
        }
        $data['transactions'][1]['customer_job_project_name'] = "";
        $data['transactions'][1]['class'] = "";
        $data['transactions'][1]['debit'] = "";
        $data['transactions'][1]['credit'] = $results['Transfer']['Amount'];

        return $data; 
    }
}
