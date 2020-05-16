<?php

namespace App\Exports;

use App\MoneyReceipt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Company;
use App\Setting;
use Illuminate\Http\Request;

class MRExportView implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $company     = Company::where('id',1)->first();
        $site_office = "All";
        $customer    = "All";
        $from_date = date('01-m-Y');
        $to_date   = date('d-m-Y');

        $money_receipts = MoneyReceipt::orderBy('created_at','desc');
        if(request()->site_office != "" && request()->site_office != "All"){
            $money_receipts = $money_receipts->where('site_office_name',request()->site_office);
            $site_office = request()->site_office;
        }
        if(request()->customer != "" && request()->customer != "All"){
            $money_receipts = $money_receipts->where('customer_name',request()->customer);
            $customer = request()->customer;
        }
        if(request()->from_date != "" && request()->to_date != ""){
            $money_receipts = $money_receipts->whereBetween('created_at', [date('Y-m-d',strtotime(request()->from_date)), date('Y-m-d',strtotime(request()->to_date)).' 23:59']);
            $from_date  = request()->from_date;
            $to_date    = request()->to_date;
        }else{
            $money_receipts = $money_receipts->whereBetween('created_at', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);
        }
        $money_receipts = $money_receipts->where('status','!=',3)->get();

        $setting = Setting::where('id',1)->first();

        return view('reports.issued_mr_table', [
            'money_receipts'    => $money_receipts, 
            'setting'           => $setting, 
            'site_office'       => $site_office, 
            'customer'          => $customer, 
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'company'           => $company,
            'total'             => request()->total
        ]);
    }
}
