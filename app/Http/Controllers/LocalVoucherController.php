<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Voucher;
use App\VoucherDetail;
use App\VoucherFormat;
use App\Company;
use App\Setting;
use Auth;

class LocalVoucherController extends Controller
{
    public function add_voucher(Request $request){
        if($request->print_status == "printed") {
            $voucher = Voucher::where('type',$request->type)
                        ->where('api_type',$request->api_type)
                        ->where('document_id',$request->document_id)
                        ->where('company_id',Auth::user()->company_id)
                        ->first();
            Voucher::where('id',$voucher->id)->delete();
            VoucherDetail::where('voucher_id',$voucher->id)->delete();
        }
        $voucher = new Voucher();
        $voucher->document_id   = $request->document_id;
        $voucher->type          = $request->type;
        $voucher->api_type      = $request->api_type;
        $voucher->company_id    = Auth::user()->company_id;
        $voucher->voucher_no    = $request->voucher_no;
        $voucher->voucher_date  = date('Y-m-d',strtotime($request->voucher_date));
        $voucher->payee_name    = $request->payee_name;
        $voucher->received_from = $request->received_from;
        $voucher->cheque_no     = $request->cheque_no;
        $voucher->cheque_date   = date('Y-m-d',strtotime($request->cheque_date));
        $voucher->location      = $request->location;

        $voucher->total_debit   = $request->total_debit;
        $voucher->total_credit  = $request->total_credit;
        $voucher->amount_in_word= $request->amount_in_word;
        $voucher->memo          = $request->memo;

        $voucher->save();

        $details = [];
        $details_count = count($request->account_code_name) - 1;
        for($i = 0; $i <= $details_count; $i++) {
            $details[$i]['account_code_name'] = $request->account_code_name[$i];
            $details[$i]['memo'] = $request->memoDetails[$i];
            $details[$i]['customer_job_project_name'] = $request->customer_job_project_name[$i];
            $details[$i]['class'] = $request->class[$i];
            $details[$i]['debit'] = $request->debit[$i];
            $details[$i]['credit'] = $request->credit[$i];
        }
        
        foreach($details as $detail){
            $voucher_detail = new VoucherDetail();
            $voucher_detail->voucher_id                 = $voucher->id;
            $voucher_detail->account_code_name          = $detail['account_code_name'];
            $voucher_detail->memo                       = $detail['memo'];
            $voucher_detail->customer_job_project_name  = $detail['customer_job_project_name'];
            $voucher_detail->class                      = $detail['class'];
            $voucher_detail->debit                      = $detail['debit'];
            $voucher_detail->credit                     = $detail['credit'];
            $voucher_detail->save();

        }

        if($request->voucher_format_id == ""){
            $format = "default";
        }else{ $format = $request->voucher_format_id; }
        return redirect('voucher-print/'.$request->type.'/'.$format.'/'.$voucher->id);
    }

    public function print($voucher_type,$format_id,$voucher_id){
        if($format_id == "default") {
            $layout = VoucherFormat::where('title','Default')->where('company_id',NULL)->first();
        }else{
            $layout = VoucherFormat::where('id',$format_id)->first();
        }

        $settings = Setting::where('company_id',Auth::user()->company_id)->first();
        $company = Company::where('id',Auth::user()->company_id)->first();
        $voucher = Voucher::where('id',$voucher_id)->first();
        $voucher_details = VoucherDetail::where('voucher_id',$voucher_id)->get();
        
        return view('local_vouchers.print',compact('settings','company','layout','voucher','voucher_details'));
    }

    public function void_voucher(){
        $voucher = Voucher::where('status',0)->get();
        return view('vouchers.void_voucher', ['vouchers' => $voucher]);
    }
}
