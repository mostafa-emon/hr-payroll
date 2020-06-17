<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Voucher;
use App\VoucherDetail;
use Auth;

class LocalVoucherController extends Controller
{
    public function add_voucher(Request $request){
        if($request->voucher_date !=""){
            $voucher = new Voucher();
            $voucher->type          = $request->type;
            $voucher->company_id    = Auth::user()->company_id;
            $voucher->voucher_no    = $request->voucher_no;
            $voucher->voucher_date  = date('Y-m-d',strtotime($request->voucher_date));
            $voucher->payee_name    = $request->payee_name;
            $voucher->received_from = $request->received_from;
            $voucher->cheque_no     = $request->cheque_no;
            $voucher->cheque_date   = date('Y-m-d',strtotime($request->cheque_date));
            $voucher->location      = $request->location;
            $voucher->save();

            $details = [];
            $details_count = count($request->account_code_name) - 1;
            for($i = 0; $i <= $details_count; $i++) {
                $details[$i]['account_code_name'] = $request->account_code_name[$i];
                $details[$i]['memo'] = $request->memo[$i];
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
            
            return redirect('tr-cash-payment-voucher');
        }
        return view('vouchers.print_preview');
    }


}
