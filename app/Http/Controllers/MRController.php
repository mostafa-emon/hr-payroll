<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyReceipt;
use App\SiteOffice;
use App\Customer;
use App\Currency;
use App\PaymentMethod;
use App\Setting;
use App\Voucher;
use App\Company;
use Auth;

class MRController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $money_receipts = MoneyReceipt::where('company_id',Auth::user()->company_id)->paginate(10);
        $setting = Setting::where('company_id',Auth::user()->company_id)->first();
        return view('mr.index', ['money_receipts' => $money_receipts, 'setting' => $setting]);
    }

    public function create_mr(){
        return view('vouchers.create_mr');
    }

    public function create_cheque(){
        return view('vouchers.create_cheque');
    }

    public function issued_voucher(Request $request){
        $vouchers = [];
        $amount = "";
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if($request->from_date != "") {$from_date = date('Y-m-d',strtotime($request->from_date));}
        if($request->to_date != "") {$to_date = date('Y-m-d',strtotime($request->to_date));}

        $payee_name = "";
        $memo = "";
        if($request->voucher_type != ""){
            $vouchers = Voucher::where('type',$request->voucher_type)
                        ->whereBetween('voucher_date', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);

            if($request->payee_name != ""){
                $payee_name = $request->payee_name;
                $vouchers = $vouchers->where('payee_name',$request->payee_name);
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
        }
        
        $setting        = Setting::where('company_id', Auth::user()->company_id)->first();
        $company        = Company::where('id', Auth::user()->company_id)->first();
        return view('reports.issued_voucher', compact('vouchers','amount','from_date','to_date','payee_name','memo','setting','company'));
    }

    public function void_voucher(Request $request){
        $vouchers = [];
        $amount = "";
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if($request->from_date != "") {$from_date = date('Y-m-d',strtotime($request->from_date));}
        if($request->to_date != "") {$to_date = date('Y-m-d',strtotime($request->to_date));}

        $payee_name = "";
        $memo = "";
        if($request->voucher_type != ""){
            $vouchers = Voucher::where('type',$request->voucher_type)
                        ->whereBetween('voucher_date', [date('Y-m-d',strtotime($from_date)), date('Y-m-d',strtotime($to_date)).' 23:59']);

            if($request->payee_name != ""){
                $payee_name = $request->payee_name;
                $vouchers = $vouchers->where('payee_name',$request->payee_name);
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
        }
        
        $setting        = Setting::where('company_id', Auth::user()->company_id)->first();
        $company        = Company::where('id', Auth::user()->company_id)->first();
        return view('reports.void_voucher', compact('vouchers','amount','from_date','to_date','payee_name','memo','setting','company'));
    }
}
