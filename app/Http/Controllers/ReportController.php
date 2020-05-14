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
use App\Audit;

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
        $money_receipts = $money_receipts->where('status','!=',3)->get();

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
        $accounts       = "";
        $cheque_book    = "All";
        $cheque_books   = "";
        $supplier_name  = "All";
        $from_date      = "";
        $to_date        = "";

        $cheques = ChequeTransaction::orderBy('created_at','desc');
        if($request->bank_id != "" && $request->bank_id != "All"){
            $bank_name = Bank::where('id',$request->bank_id)->value('name');
            $cheques = $cheques->where('bank_name',$bank_name);
            $accounts = BankAccount::where('bank_id',$request->bank_id)->get();
        }
        if($request->account_id != "" && $request->account_id != "All"){
            $ac_number = BankAccount::where('id',$request->account_id)->value('ac_number');
            $cheques   = $cheques->where('ac_number',$ac_number);
            $cheque_books = ChequeBook::where('account_id',$request->account_id)->get();
        }
        if($request->book_no != "" && $request->book_no != "All"){
            $cheque_book = $request->book_no;
            $cheques   = $cheques->where('book_no',$cheque_book);
            $cheque_books = ChequeBook::where('account_id',$request->account_id)->get();
        }
        if($request->supplier != "" && $request->supplier != "All"){
            $cheques = $cheques->where('cheque_name',$request->supplier);
            $supplier_name = $request->supplier;
        }
        if($request->from_date != "" && $request->to_date != ""){
            $cheques = $cheques->whereBetween('date', [date('Y-m-d',strtotime($request->from_date)), date('Y-m-d',strtotime($request->to_date)).' 23:59']);
            $from_date  = $request->from_date;
            $to_date    = $request->to_date;
        }
        $cheques = $cheques->where('status','!=',3)->get();

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
            'ac_number'         => $ac_number, 
            'cheque_book'       => $cheque_book, 
            'suppliers'         => $suppliers,
            'supplier_name'     => $supplier_name,
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'accounts'          => $accounts,
            'cheque_books'      => $cheque_books
        ]);
    }

    public function void_cheque(Request $request) {
        
        $bank_name      = "All";
        $ac_number      = "All";
        $accounts       = "";
        $cheque_book    = "All";
        $cheque_books   = "";
        $supplier_name  = "All";
        $from_date      = "";
        $to_date        = "";

        $cheques = ChequeTransaction::orderBy('created_at','desc');
        if($request->bank_id != "" && $request->bank_id != "All"){
            $bank_name = Bank::where('id',$request->bank_id)->value('name');
            $cheques = $cheques->where('bank_name',$bank_name);
            $accounts = BankAccount::where('bank_id',$request->bank_id)->get();
        }
        if($request->account_id != "" && $request->account_id != "All"){
            $ac_number = BankAccount::where('id',$request->account_id)->value('ac_number');
            $cheques   = $cheques->where('ac_number',$ac_number);
            $cheque_books = ChequeBook::where('account_id',$request->account_id)->get();
        }
        if($request->book_no != "" && $request->book_no != "All"){
            $cheque_book = $request->book_no;
            $cheques   = $cheques->where('book_no',$cheque_book);
            $cheque_books = ChequeBook::where('account_id',$request->account_id)->get();
        }
        if($request->supplier != "" && $request->supplier != "All"){
            $cheques = $cheques->where('cheque_name',$request->supplier);
            $supplier_name = $request->supplier;
        }
        if($request->from_date != "" && $request->to_date != ""){
            $cheques = $cheques->whereBetween('date', [date('Y-m-d',strtotime($request->from_date)), date('Y-m-d',strtotime($request->to_date)).' 23:59']);
            $from_date  = $request->from_date;
            $to_date    = $request->to_date;
        }
        $cheques = $cheques->where('status','3')->get();

        $banks     = Bank::orderBy('name','asc')->get();
        $suppliers = Supplier::orderBy('name','asc')->get();
        $setting = Setting::where('id',1)->first();
        $title = "Void Cheques";

        return view('reports.void_cheque', [
            'cheques'           => $cheques, 
            'setting'           => $setting, 
            'title'             => $title, 
            'banks'             => $banks, 
            'bank_name'         => $bank_name, 
            'ac_number'         => $ac_number, 
            'cheque_book'       => $cheque_book, 
            'suppliers'         => $suppliers,
            'supplier_name'     => $supplier_name,
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'accounts'          => $accounts,
            'cheque_books'      => $cheque_books
        ]);
    }

    public function audits(Request $request){
        $from_date = date('d-m-Y', strtotime('-7 days'));
        $to_date = date('d-m-Y');

        $date_formated_from = date('Y-m-d', strtotime('-7 days'));
        $date_formated_to = date('Y-m-d');

        if($request->from_date != "" && $request->to_date != ""){
            $date_formated_from = date('Y-m-d', strtotime($request->from_date));
            $date_formated_to = date('Y-m-d', strtotime($request->to_date));

            $from_date = date('d-m-Y', strtotime($request->from_date));
            $to_date = date('d-m-Y', strtotime($request->to_date));
        }
        $audits = Audit::select('audits.*','users.name as user_name')
                ->join('users','users.id','audits.user_id')
                ->whereBetween('audits.created_at', [$date_formated_from, $date_formated_to.' 23:59'])
                ->orderBy('audits.created_at','desc')
                ->get();
        return view('reports.audits',['audits' => $audits, 'from_date' => $from_date, 'to_date' => $to_date]);
    }
}
