<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyReceipt;
use App\Setting;
use App\SiteOffice;
use App\Customer;
use App\ChequeTransaction;
use App\Bank;
use App\BankAccount;
use App\ChequeBook;
use App\Supplier;

class ReportController extends Controller
{
    public function issued_mr(Request $request) {
        
        $site_office = "All";
        $customer    = "All";
        $from_date   = "";
        $to_date     = "";

        $money_receipts = MoneyReceipt::orderBy('created_at','desc');
        if($request->site_office != "" && $request->site_office != "All"){
            $money_receipts = $money_receipts->where('site_office_name',$request->site_office);
            $site_office = $request->site_office;
        }
        if($request->customer != "" && $request->customer != "All"){
            $money_receipts = $money_receipts->where('customer_name',$request->customer);
            $customer = $request->customer;
        }
        if($request->from_date != "" && $request->to_date != ""){
            $money_receipts = $money_receipts->whereBetween('created_at', [date('Y-m-d',strtotime($request->from_date)), date('Y-m-d',strtotime($request->to_date)).' 23:59']);
            $from_date  = $request->from_date;
            $to_date    = $request->to_date;
        }
        $money_receipts = $money_receipts->where('status','!=3')->get();

        $site_offices = SiteOffice::orderBy('name','asc')->get();
        $customers = Customer::orderBy('name','asc')->get();
        $setting = Setting::where('id',1)->first();
        $title = "Issued Money Receipts";

        return view('reports.issued_mr', [
            'money_receipts'    => $money_receipts, 
            'setting'           => $setting, 
            'title'             => $title, 
            'site_offices'      => $site_offices, 
            'site_office'       => $site_office, 
            'customers'         => $customers, 
            'customer'          => $customer, 
            'from_date'         => $from_date,
            'to_date'           => $to_date
        ]);
    }

    public function void_mr(Request $request) {
        
        $site_office = "All";
        $customer    = "All";
        $from_date   = "";
        $to_date     = "";

        $money_receipts = MoneyReceipt::orderBy('created_at','desc');
        if($request->site_office != "" && $request->site_office != "All"){
            $money_receipts = $money_receipts->where('site_office_name',$request->site_office);
            $site_office = $request->site_office;
        }
        if($request->customer != "" && $request->customer != "All"){
            $money_receipts = $money_receipts->where('customer_name',$request->customer);
            $customer = $request->customer;
        }
        if($request->from_date != "" && $request->to_date != ""){
            $money_receipts = $money_receipts->whereBetween('created_at', [date('Y-m-d',strtotime($request->from_date)), date('Y-m-d',strtotime($request->to_date)).' 23:59']);
            $from_date  = $request->from_date;
            $to_date    = $request->to_date;
        }
        $money_receipts = $money_receipts->where('status','3')->get();

        $site_offices = SiteOffice::orderBy('name','asc')->get();
        $customers = Customer::orderBy('name','asc')->get();
        $setting = Setting::where('id',1)->first();
        $title = "Void Money Receipts";

        return view('reports.void_mr', [
            'money_receipts'    => $money_receipts, 
            'setting'           => $setting, 
            'title'             => $title, 
            'site_offices'      => $site_offices, 
            'site_office'       => $site_office, 
            'customers'         => $customers, 
            'customer'          => $customer, 
            'from_date'         => $from_date,
            'to_date'           => $to_date
        ]);
    }

    public function issued_cheque(Request $request) {
        
        $bank_name      = "All";
        $ac_number      = "All";
        $cheque_book    = "All";
        $supplier_name  = "All";
        $from_date      = "";
        $to_date        = "";

        $cheques = ChequeTransaction::orderBy('created_at','desc');
        
        $cheques = $cheques->where('status','!=3')->get();

        $banks     = Bank::orderBy('name','asc')->get();
        $suppliers = Supplier::orderBy('name','asc')->get();
        $setting = Setting::where('id',1)->first();
        $title = "Issued Cheques";

        return view('reports.issued_cheque', [
            'cheques'           => $cheques, 
            'setting'           => $setting, 
            'title'             => $title, 
            'banks'             => $banks, 
            'bank_name'         => $bank_name, 
            'suppliers'         => $suppliers,
            'supplier_name'     => $supplier_name,
            'from_date'         => $from_date,
            'to_date'           => $to_date
        ]);
    }
}
