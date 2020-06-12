<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyReceipt;
use App\SiteOffice;
use App\Customer;
use App\Currency;
use App\PaymentMethod;
use App\Setting;
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
}
