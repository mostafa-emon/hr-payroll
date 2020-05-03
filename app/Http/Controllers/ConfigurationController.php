<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\PaymentMethod;
use App\Setting;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index_currency(){
        $currency = Currency::orderBy('id', 'asc')->paginate(10);
        return view('currencies.index', ['currencies'=>$currency]);
    }
    
    public function add_currency(Request $request){
        if($request->full_name !=""){
            $currency = new Currency();
            $currency->full_name        = $request->full_name;
            $currency->fraction_name    = $request->fraction_name;
            $currency->save();
            return redirect('currency')->with('message', 'Currency added successfully!');
        }
        return view('currencies.add');
    }

    public function delete_currency($currency_id){
        $currency = Currency::find($currency_id);
        $currency->delete();
        return redirect('currency')->with('message', 'Currency deleted successfully!');
    }

    public function update_currency($currency_id, Request $request){
        if($request->full_name !=""){
            $currency = Currency::where('id',$currency_id)->first();
            $currency->full_name        = $request->full_name;
            $currency->fraction_name    = $request->fraction_name;
            $currency->save();
            return redirect('currency')->with('message', 'Currency updated successfully!');
        }
        $currencies = Currency::where('id',$currency_id)->first();
        return view('currencies.update', ['currencies' => $currencies]);
    }

    
    public function index_payment_method(){
        $payment_method = PaymentMethod::orderBy('id', 'asc')->paginate(10);
        return view('payment_methods.index', ['payment_methods'=>$payment_method]);
    }
    
    public function add_payment_method(Request $request){
        if($request->method_name !=""){
            $payment_method = new PaymentMethod();
            $payment_method->method_name        = $request->method_name;
            $payment_method->save();
            return redirect('payment-method')->with('message', 'Payment Method added successfully!');
        }
        return view('payment_methods.add');
    }

    public function delete_payment_method($payment_method_id){
        $payment_method = PaymentMethod::find($payment_method_id);
        $payment_method->delete();
        return redirect('payment-method')->with('message', 'Payment Method deleted successfully!');
    }

    public function update_payment_method($payment_method_id, Request $request){
        if($request->method_name !=""){
            $payment_method = PaymentMethod::where('id',$payment_method_id)->first();
            $payment_method->method_name        = $request->method_name;
            $payment_method->save();
            return redirect('payment-method')->with('message', 'Payment Method updated successfully!');
        }
        $payment_methods = PaymentMethod::where('id',$payment_method_id)->first();
        return view('payment_methods.update', ['payment_methods' => $payment_methods]);
    }

    public function index() {
        $settings = Setting::where('id',1)->first();
        return view('settings.index', ['settings' => $settings]);
    }

    public function update(Request $request){
        $count = Setting::where('id',1)->count();

        if($count == 0) {
            $setting = new Setting;
            $setting->mr_number                 = $request->mr_number;
            $setting->mr_size                   = $request->mr_size;
            $setting->amount_in_word_format     = $request->amount_in_word_format;
            $setting->approval_for_mr           = $request->approval_for_mr;
            $setting->approval_for_cheque       = $request->approval_for_cheque;
            $setting->save();
        }else{
            $setting = Setting::where('id',1)->first();
            $setting->mr_number                 = $request->mr_number;
            $setting->mr_size                   = $request->mr_size;
            $setting->amount_in_word_format     = $request->amount_in_word_format;
            $setting->approval_for_mr           = $request->approval_for_mr;
            $setting->approval_for_cheque       = $request->approval_for_cheque;
            $setting->save();
        }
        return redirect('settings')->with('message','Settings updated successfully!');
    }
}
