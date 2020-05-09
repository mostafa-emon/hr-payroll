<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyReceipt;
use App\SiteOffice;
use App\Customer;
use App\Currency;
use App\PaymentMethod;
use App\Setting;

class MRController extends Controller
{
    public function index(){
        $money_receipts = MoneyReceipt::all();
        return view('mr.index', ['money_receipts' => $money_receipts]);
    }

    public function add(Request $request){
        if($request->customer_name !=""){
            list($site_office_name,$prefix,$suffix,$mr_start_from) = explode('_',$request->site_office);
            
            $last_invoice = MoneyReceipt::where('site_office_name',$site_office_name)->orderBy('created_at','desc')->first();
            if(!isset($last_invoice->invoice_no)){
                $setting = Setting::where('id',1)->first();
                if($setting->mr_number == "auto"){
                    $invoice_no = 1;
                }else{
                    $invoice_no = $mr_start_from;
                }
            }else{
                $invoice_no = $last_invoice->invoice_no + 1;
            }
            
            $mr = new MoneyReceipt();
            $mr->site_office_name       = $site_office_name;
            $mr->site_office_prefix     = $prefix;
            $mr->site_office_suffix     = $suffix;
            $mr->invoice_no             = $invoice_no;
            $mr->customer_name          = $request->customer_name;
            $mr->amount                 = $request->amount;
            $mr->currency               = $request->currency;
            $mr->amount_in_word         = $request->amount_in_words;
            $mr->payment_method         = $request->payment_method;
            $mr->cheque_no              = $request->cheque_no;
            $mr->cheque_date            = date('Y-m-d',strtotime($request->cheque_date));
            $mr->bank_name              = $request->bank_name;
            $mr->purpose                = $request->purpose;
            $mr->save();
            return redirect('mr')->with('message', 'Money receipt added successfully!');
        }
        $site_offices   = SiteOffice::orderBy('name','asc')->get();
        $customers      = Customer::orderBy('name','asc')->get();
        $currency       = Currency::orderBy('id','asc')->get();
        $payment_methods= PaymentMethod::orderBy('id','asc')->get();
        $setting        = Setting::where('id',1)->first();
        return view('mr.add', ['site_offices' => $site_offices, 'customers' => $customers, 'currency' => $currency, 'payment_methods' => $payment_methods, 'setting' => $setting]);
    }
}
