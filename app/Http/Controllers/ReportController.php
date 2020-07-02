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
use App\Company;
use App\Voucher;
use Excel;
use Auth;
use App\Exports\VoucherExportView;
use App\Exports\VoucherVoidExportView;
use App\Exports\MRExportView;
use App\Exports\MRVoidExportView;
use App\Exports\ChequeExportView;
use App\Exports\ChequeVoidExportView;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function issued_mr(Request $request) {
        $company     = Company::where('id', Auth::user()->company_id)->first();
        $site_office = "All";
        $customer    = "All";
        $from_date = date('01-m-Y');
        $to_date   = date('d-m-Y');

        $money_receipts = MoneyReceipt::where('company_id', Auth::user()->company_id)->orderBy('created_at','desc');
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
        }else{
            $money_receipts = $money_receipts->whereBetween('created_at', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);
        }
        $money_receipts = $money_receipts->where('status','!=',3)->get();

        $total = 0; 
        foreach($money_receipts as $money_receipt) {
            $total = $total + (float) filter_var( $money_receipt->amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
        }

        $site_offices = SiteOffice::where('company_id', Auth::user()->company_id)->orderBy('name','asc')->get();
        $customers = Customer::where('company_id', Auth::user()->company_id)->orderBy('name','asc')->get();
        $setting = Setting::where('company_id', Auth::user()->company_id)->first();

        return view('reports.issued_mr', [
            'money_receipts'    => $money_receipts, 
            'setting'           => $setting, 
            'site_offices'      => $site_offices, 
            'site_office'       => $site_office, 
            'customers'         => $customers, 
            'customer'          => $customer, 
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'company'           => $company,
            'total'             => $total
        ]);
    }

    public function export_issued_mr(){
        return Excel::download(new MRExportView(), 'Issued Money Receipt.xlsx');
    }

    public function void_mr(Request $request) {
        $company     = Company::where('id', Auth::user()->company_id)->first();
        $site_office = "All";
        $customer    = "All";
        $from_date = date('01-m-Y');
        $to_date   = date('d-m-Y');

        $money_receipts = MoneyReceipt::where('company_id', Auth::user()->company_id)->orderBy('created_at','desc');
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
        }else{
            $money_receipts = $money_receipts->whereBetween('created_at', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);
        }
        $money_receipts = $money_receipts->where('status','3')->get();

        $total = 0; 
        foreach($money_receipts as $money_receipt) {
            $total = $total + (float) filter_var( $money_receipt->amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
        }

        $site_offices = SiteOffice::where('company_id', Auth::user()->company_id)->orderBy('name','asc')->get();
        $customers = Customer::where('company_id', Auth::user()->company_id)->orderBy('name','asc')->get();
        $setting = Setting::where('company_id', Auth::user()->company_id)->first();

        return view('reports.void_mr', [
            'money_receipts'    => $money_receipts, 
            'setting'           => $setting, 
            'site_offices'      => $site_offices, 
            'site_office'       => $site_office, 
            'customers'         => $customers, 
            'customer'          => $customer, 
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'company'           => $company,
            'total'             => $total
        ]);
    }

    public function export_void_mr(){
        return Excel::download(new MRVoidExportView(), 'Void Money Receipt.xlsx');
    }

    public function issued_cheque(Request $request) {
        $company        = Company::where('id', Auth::user()->company_id)->first();
        $bank_name      = "All";
        $ac_number      = "All";
        $accounts       = "";
        $cheque_book    = "All";
        $cheque_books   = "";
        $from_date = date('01-m-Y');
        $to_date   = date('d-m-Y');
        $cheque_name = "";
        $amount = "";
        $formatted_amount = "";

        $cheques = ChequeTransaction::where('company_id', Auth::user()->company_id)->orderBy('created_at','desc');

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

        if($request->cheque_name != ""){
            $cheque_name = $request->cheque_name;
            $cheques = $cheques->where('cheque_name','LIKE', '%'.$request->cheque_name.'%');
        }

        if($request->formatted_amount != ""){
            $formatted_amount = $request->formatted_amount;
            $cheques = $cheques->where('amount',$request->formatted_amount);
        }

        if($request->from_date != "" && $request->to_date != ""){
            $cheques = $cheques->whereBetween('date', [date('Y-m-d',strtotime($request->from_date)), date('Y-m-d',strtotime($request->to_date)).' 23:59']);
            $from_date  = $request->from_date;
            $to_date    = $request->to_date;
        }else{
            $cheques = $cheques->whereBetween('date', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);
        }
        $cheques = $cheques->where('status',1)->get();

        $total = 0; 
        foreach($cheques as $cheque) {
            $total = $total + (float) filter_var( $cheque->amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
        }

        $banks     = Bank::where('company_id', Auth::user()->company_id)->orderBy('name','asc')->get();
        $setting = Setting::where('company_id', Auth::user()->company_id)->first();

        return view('reports.issued_cheque', [
            'cheques'           => $cheques, 
            'setting'           => $setting, 
            'banks'             => $banks, 
            'bank_name'         => $bank_name, 
            'ac_number'         => $ac_number, 
            'cheque_book'       => $cheque_book, 
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'accounts'          => $accounts,
            'cheque_books'      => $cheque_books,
            'company'           => $company,
            'total'             => $total,
            'amount'            => $amount,
            'cheque_name'       => $cheque_name,
            'formatted_amount'  => $formatted_amount
        ]);
    }

    public function export_issued_cheque(){
        return Excel::download(new ChequeExportView(), 'Issued Cheque.xlsx');
    }

    public function void_cheque(Request $request) {
        $company        = Company::where('id', Auth::user()->company_id)->first();
        $bank_name      = "All";
        $ac_number      = "All";
        $accounts       = "";
        $cheque_book    = "All";
        $cheque_books   = "";
        $from_date = date('01-m-Y');
        $to_date   = date('d-m-Y');
        $cheque_name = "";
        $amount = "";
        $formatted_amount = "";


        $cheques = ChequeTransaction::where('company_id', Auth::user()->company_id)->orderBy('created_at','desc');
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

        if($request->cheque_name != ""){
            $cheque_name = $request->cheque_name;
            $cheques = $cheques->where('cheque_name','LIKE', '%'.$request->cheque_name.'%');
        }

        if($request->formatted_amount != ""){
            $formatted_amount = $request->formatted_amount;
            $cheques = $cheques->where('amount',$request->formatted_amount);
        }


        if($request->from_date != "" && $request->to_date != ""){
            $cheques = $cheques->whereBetween('date', [date('Y-m-d',strtotime($request->from_date)), date('Y-m-d',strtotime($request->to_date)).' 23:59']);
            $from_date  = $request->from_date;
            $to_date    = $request->to_date;
        }else{
            $cheques = $cheques->whereBetween('date', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);
        }
        $cheques = $cheques->where('status',0)->get();

        $total = 0; 
        foreach($cheques as $cheque) {
            $total = $total + (float) filter_var( $cheque->amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
        }

        $banks     = Bank::where('company_id', Auth::user()->company_id)->orderBy('name','asc')->get();
        $setting = Setting::where('company_id', Auth::user()->company_id)->first();

        return view('reports.void_cheque', [
            'cheques'           => $cheques, 
            'setting'           => $setting, 
            'banks'             => $banks, 
            'bank_name'         => $bank_name, 
            'ac_number'         => $ac_number, 
            'cheque_book'       => $cheque_book,
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'accounts'          => $accounts,
            'cheque_books'      => $cheque_books,
            'company'           => $company,
            'total'             => $total,
            'amount'            => $amount,
            'cheque_name'        => $cheque_name,
            'formatted_amount'  => $formatted_amount

        ]);
    }

    public function export_void_cheque(){
        return Excel::download(new ChequeVoidExportView(), 'Void Cheque.xlsx');
    }

    public function issued_voucher(Request $request){
        $vouchers = [];
        $voucher_type = "";
        $amount = "";
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if($request->from_date != "") {$from_date = date('Y-m-d',strtotime($request->from_date));}
        if($request->to_date != "") {$to_date = date('Y-m-d',strtotime($request->to_date));}

        $payee_name = "";
        $received_from = "";
        $memo = "";
        $vouchers = Voucher::whereBetween('voucher_date', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);

        if($request->voucher_type != "") {
            $voucher_type = $request->voucher_type;
            $vouchers = $vouchers->where('type',$request->voucher_type);
        }
        if($request->payee_name != ""){
            $payee_name = $request->payee_name;
            $vouchers = $vouchers->where('payee_name','LIKE', '%'.$request->payee_name.'%');
        }

        if($request->received_from != ""){
            $received_from = $request->received_from;
            $vouchers = $vouchers->where('received_from','LIKE', '%'.$request->received_from.'%');
        }

        if($request->amount != ""){
            $amount = $request->amount;
            $vouchers = $vouchers->where('total_credit',$request->amount);
        }

        if($request->memo != ""){
            $memo = $request->memo;
            $vouchers = $vouchers->where('memo','LIKE', '%'.$request->memo.'%');
        }

        $vouchers = $vouchers->where('company_id', Auth::user()->company_id)->where('status',1)->get();
        
        $setting        = Setting::where('company_id', Auth::user()->company_id)->first();
        $company        = Company::where('id', Auth::user()->company_id)->first();
        return view('reports.issued_voucher', compact('vouchers','voucher_type','amount','from_date','to_date','payee_name','received_from','memo','setting','company'));
    }

    public function export_issued_voucher(){
        return Excel::download(new VoucherExportView(), 'Issued Vouchers.xlsx');
    }

    public function void_voucher(Request $request){
        $vouchers = [];
        $voucher_type = "";
        $amount = "";
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if($request->from_date != "") {$from_date = date('Y-m-d',strtotime($request->from_date));}
        if($request->to_date != "") {$to_date = date('Y-m-d',strtotime($request->to_date));}

        $payee_name = "";
        $received_from = "";
        $memo = "";

        $vouchers = Voucher::whereBetween('voucher_date', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);

        if($request->voucher_type != "") {
            $voucher_type = $request->voucher_type;
            $vouchers = $vouchers->where('type',$request->voucher_type);
        }
        if($request->payee_name != ""){
            $payee_name = $request->payee_name;
            $vouchers = $vouchers->where('payee_name','LIKE', '%'.$request->payee_name.'%');
        }

        if($request->received_from != ""){
            $received_from = $request->received_from;
            $vouchers = $vouchers->where('received_from','LIKE', '%'.$request->received_from.'%');
        }

        if($request->amount != ""){
            $amount = $request->amount;
            $vouchers = $vouchers->where('total_credit',$request->amount);
        }

        if($request->memo != ""){
            $memo = $request->memo;
            $vouchers = $vouchers->where('memo','LIKE', '%'.$request->memo.'%');
        }

        $vouchers = $vouchers->where('company_id', Auth::user()->company_id)->where('status',0)->get();
        
        $setting        = Setting::where('company_id', Auth::user()->company_id)->first();
        $company        = Company::where('id', Auth::user()->company_id)->first();
        return view('reports.void_voucher', compact('vouchers','voucher_type','amount','from_date','to_date','payee_name','received_from','memo','setting','company'));
    }

    public function export_void_voucher(){
        return Excel::download(new VoucherVoidExportView(), 'Void Vouchers.xlsx');
    }

    public function audits(Request $request){
        if(roles() != "" && !in_array(83, json_decode(roles(),false))){
            return redirect('404');
        }
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
                ->where('audits.company_id', Auth::user()->company_id)
                ->paginate(10);
        return view('reports.audits',['audits' => $audits, 'from_date' => $from_date, 'to_date' => $to_date]);
    }
}
