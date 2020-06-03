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
    public function index(){
        $money_receipts = MoneyReceipt::where('company_id',Auth::user()->company_id)->paginate(10);
        $setting = Setting::where('company_id',Auth::user()->company_id)->first();
        return view('mr.index', ['money_receipts' => $money_receipts, 'setting' => $setting]);
    }

    public function add(Request $request){
        if(roles() != "" && !in_array(35, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->customer_name !=""){
            list($site_office_name,$prefix,$suffix,$mr_start_from) = explode('_',$request->site_office);
            $setting = Setting::where('company_id',Auth::user()->company_id)->first();
            // NEW INVOICE NO CODE
            if($setting->mr_number == "auto"){
                $last_invoice = MoneyReceipt::where('company_id',Auth::user()->company_id)->where('site_office_name',$site_office_name)->orderBy('created_at','desc')->first();
                if(!isset($last_invoice->invoice_no)){
                    $invoice_no = $mr_start_from;
                } else{
                    if($last_invoice->site_office_prefix == $prefix && $last_invoice->site_office_suffix == $suffix) {
                        $invoice_no = $last_invoice->invoice_no + 1;
                    }else{
                        $invoice_no = $mr_start_from;
                    }
                }
            }else{
                $invoice_no = $request->invoice_no;
            }
            
            list($currency_full_name,$currency_fraction_name) = explode("_",$request->currency);
            $mr = new MoneyReceipt();
            $mr->site_office_name       = $site_office_name;

            if($setting->mr_number == "manual"){
                $mr->site_office_prefix     = "";
                $mr->site_office_suffix     = "";
            }else{
                $mr->site_office_prefix     = $prefix;
                $mr->site_office_suffix     = $suffix;
            }
            
            $mr->invoice_no             = $invoice_no;
            $mr->customer_name          = $request->customer_name;
            $mr->amount                 = $request->amount;
            $mr->currency               = $currency_full_name;
            $mr->amount_in_word         = $request->amount_in_words;
            $mr->payment_method         = $request->payment_method;
            $mr->cheque_no              = $request->cheque_no;
            $mr->cheque_date            = date('Y-m-d',strtotime($request->cheque_date));
            $mr->bank_name              = $request->bank_name;
            $mr->purpose                = $request->purpose;

            $mr->company_id             = Auth::user()->company_id;
            $mr->save();
            return redirect('mr')->with('message', 'Money receipt added successfully!');
        }
        $site_offices   = SiteOffice::orderBy('name','asc')->get();
        $customers      = Customer::orderBy('name','asc')->get();
        $currency       = Currency::orderBy('id','asc')->get();
        $payment_methods= PaymentMethod::orderBy('id','asc')->get();
        $setting        = Setting::where('company_id',Auth::user()->company_id)->first();
        return view('mr.add', ['site_offices' => $site_offices, 'customers' => $customers, 'currency' => $currency, 'payment_methods' => $payment_methods, 'setting' => $setting]);
    }

    public function approve($mr_id){
        if(roles() != "" && !in_array(36, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = MoneyReceipt::where('id',$mr_id)->first();
        $transaction->status = 1;
        $transaction->save();
        echo "Ok";                
    }

    public function reject($cheque_id){
        if(roles() != "" && !in_array(37, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = MoneyReceipt::where('id',$cheque_id)->first();
        $transaction->status = 2;
        $transaction->save();
        echo "Ok";                
    }

    public function void($cheque_id){
        if(roles() != "" && !in_array(38, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = MoneyReceipt::where('id',$cheque_id)->first();
        $transaction->status = 3;
        $transaction->save();
        echo "Ok";                
    }

    public function print($mr_id){
        if(roles() != "" && !in_array(39, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = MoneyReceipt::where('id',$mr_id)->first();
        $company     = Company::where('id',Auth::user()->company_id)->first();
        $site_office = SiteOffice::where('company_id',Auth::user()->company_id)->where('name',$transaction->site_office_name)->first();
        $customer    = Customer::where('company_id',Auth::user()->company_id)->where('name',$transaction->customer_name)->first();
        $setting     = Setting::where('company_id',Auth::user()->company_id)->first();

        if($transaction->status == 0 && $setting->approval_for_mr == 1){
            $status = "pending";
        }
        if($transaction->status == 0 && $setting->approval_for_mr == 0){
            $status = "approved";
        }
        if($transaction->status == 1){
            $status = "approved";
        }
        if($transaction->status == 2){
            $status = "rejected";
        }
        if($transaction->status == 3){
            $status = "void";
        }

        if($setting->mr_size == "full_page"){
            return view('mr.print_full', ['transaction'=>$transaction, 'company' => $company, 'site_office' => $site_office, 'customer' => $customer, 'status' => $status]);
        }else{
            return view('mr.print_half', ['transaction'=>$transaction, 'company' => $company, 'site_office' => $site_office, 'customer' => $customer, 'status' => $status]);
        }
    }

    public function draft($mr_id){
        if(roles() != "" && !in_array(39, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = MoneyReceipt::where('id',$mr_id)->first();
        $company     = Company::where('id',Auth::user()->company_id)->first();
        $site_office = SiteOffice::where('company_id',Auth::user()->company_id)->where('name',$transaction->site_office_name)->first();
        $customer    = Customer::where('company_id',Auth::user()->company_id)->where('name',$transaction->customer_name)->first();
        $setting     = Setting::where('company_id',Auth::user()->company_id)->first();

        if($setting->mr_size == "full_page"){
            return view('mr.draft_full', ['transaction'=>$transaction, 'company' => $company, 'site_office' => $site_office, 'customer' => $customer]);
        }else{
            return view('mr.draft_half', ['transaction'=>$transaction, 'company' => $company, 'site_office' => $site_office, 'customer' => $customer]);
        }
    }
}
