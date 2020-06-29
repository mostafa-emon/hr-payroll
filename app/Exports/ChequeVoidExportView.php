<?php

namespace App\Exports;

use App\ChequeTransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Company;
use App\Bank;
use App\BankAccount;
use App\ChequeBook;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChequeVoidExportView implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $company        = Company::where('id',Auth::user()->company_id)->first();
        $bank_name      = "All";
        $ac_number      = "All";
        $accounts       = "";
        $cheque_book    = "All";
        $cheque_books   = "";
        $from_date = date('01-m-Y');
        $to_date   = date('d-m-Y');

        $cheques = ChequeTransaction::orderBy('created_at','desc');
        if(request()->bank_id != "" && request()->bank_id != "All"){
            $cheques = $cheques->where('bank_name',request()->bank_id);
        }
        if(request()->account_id != "" && request()->account_id != "All"){
            $cheques   = $cheques->where('ac_number',request()->account_id);
        }
        if(request()->book_no != "" && request()->book_no != "All"){
            $cheque_book = request()->book_no;
            $cheques   = $cheques->where('book_no',$cheque_book);
            $cheque_books = ChequeBook::where('account_id',request()->account_id)->get();
        }
        if(request()->from_date != "" && request()->to_date != ""){
            $cheques = $cheques->whereBetween('date', [date('Y-m-d',strtotime(request()->from_date)), date('Y-m-d',strtotime(request()->to_date)).' 23:59']);
            $from_date  = request()->from_date;
            $to_date    = request()->to_date;
        }else{
            $cheques = $cheques->whereBetween('date', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);
        }
        $cheques = $cheques->where('status',0)->where('company_id',Auth::user()->company_id)->get();

        $setting = Setting::where('company_id',Auth::user()->company_id)->first();

        return view('reports.exports.void_cheque_table', [
            'cheques'           => $cheques, 
            'setting'           => $setting, 
            'bank_name'         => $bank_name, 
            'ac_number'         => $ac_number, 
            'cheque_book'       => $cheque_book, 
            'from_date'         => $from_date,
            'to_date'           => $to_date,
            'company'           => $company,
            'total'             => request()->total
        ]);
    }
}
