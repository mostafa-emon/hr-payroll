<?php

namespace App\Exports;

use App\MoneyReceipt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Company;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MRVoidExportView implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $company     = Company::where('id',Auth::user()->company_id)->first();
        $customer    = "";
        $from_date = date('01-m-Y');
        $to_date   = date('d-m-Y');
        $formatted_amount = "";

        $money_receipts = MoneyReceipt::orderBy('created_at','desc');
        if(request()->customer != ""){
            $money_receipts = $money_receipts->where('customer_name','LIKE', '%'.request()->customer.'%');
            $customer = request()->customer;
        }

        if(request()->formatted_amount != ""){
            $formatted_amount = request()->formatted_amount;
            $money_receipts = $money_receipts->where('amount',request()->formatted_amount);
        }

        if(request()->from_date != "" && request()->to_date != ""){
            $money_receipts = $money_receipts->whereBetween('created_at', [date('Y-m-d',strtotime(request()->from_date)), date('Y-m-d',strtotime(request()->to_date)).' 23:59']);
            $from_date  = request()->from_date;
            $to_date    = request()->to_date;
        }else{
            $money_receipts = $money_receipts->whereBetween('created_at', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);
        }
        $money_receipts = $money_receipts->where('status',0)->where('company_id',Auth::user()->company_id)->get();

        $setting = Setting::where('company_id',Auth::user()->company_id)->first();

        return view('reports.exports.void_mr_table', [
            'money_receipts'    => $money_receipts, 
            'setting'           => $setting,
            'customer'          => $customer, 
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'company'           => $company,
            'formatted_amount'  => $formatted_amount,
            'total'             => request()->total
        ]);
    }
}
