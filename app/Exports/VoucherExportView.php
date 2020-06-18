<?php

namespace App\Exports;

use App\Voucher;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Company;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherExportView implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $company     = Company::where('id',Auth::user()->company_id)->first();
        $vouchers = [];
        $voucher_type = "";
        $amount = "";
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if(request()->from_date != "") {$from_date = date('Y-m-d',strtotime(request()->from_date));}
        if(request()->to_date != "") {$to_date = date('Y-m-d',strtotime(request()->to_date));}

        $payee_name = "";
        $memo = "";
        if(request()->voucher_type != ""){
            $voucher_type = request()->voucher_type;
            $vouchers = Voucher::where('type',request()->voucher_type)
                        ->whereBetween('voucher_date', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);

            if(request()->payee_name != ""){
                $payee_name = request()->payee_name;
                $vouchers = $vouchers->where('payee_name',request()->payee_name);
            }

            if(request()->amount != ""){
                $amount = request()->amount;
                $vouchers = $vouchers->where('total_credit',request()->amount);
            }

            if(request()->memo != ""){
                $memo = request()->memo;
                $vouchers = $vouchers->where('memo','LIKE', '%'.request()->memo.'%');
            }

            $vouchers = $vouchers->where('company_id', Auth::user()->company_id)->where('status',1)->get();
        }
        
        $setting = Setting::where('company_id', Auth::user()->company_id)->first();
        return view('reports.exports.issued_voucher_table', compact('vouchers','voucher_type','amount','from_date','to_date','payee_name','memo','setting','company'));
    }
}
