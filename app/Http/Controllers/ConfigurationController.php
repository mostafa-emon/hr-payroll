<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\PaymentMethod;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function currencyindex(){
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

    public function currencydelete($currency_id){
        $currency = Currency::find($currency_id);
        $currency->delete();
        return redirect('currency')->with('message', 'Currency deleted successfully!');
    }

    public function currencyupdate($currency_id, Request $request){
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





    public function paymentmethodindex(){
        $paymentmethod = PaymentMethod::orderBy('id', 'asc')->paginate(10);
        return view('paymentmethods.index', ['paymentmethods'=>$paymentmethod]);
    }
    
    public function paymentmethodadd(Request $request){
        if($request->method_name !=""){
            $paymentmethod = new PaymentMethod();
            $paymentmethod->method_name        = $request->method_name;
            $paymentmethod->save();
            return redirect('paymentmethod')->with('message', 'Payment Method added successfully!');
        }
        return view('paymentmethods.add');
    }

    public function paymentmethoddelete($paymentmethod_id){
        $paymentmethod = PaymentMethod::find($paymentmethod_id);
        $paymentmethod->delete();
        return redirect('paymentmethod')->with('message', 'Payment Method deleted successfully!');
    }

    public function paymentmethodupdate($paymentmethod_id, Request $request){
        if($request->method_name !=""){
            $paymentmethod = PaymentMethod::where('id',$paymentmethod_id)->first();
            $paymentmethod->method_name        = $request->method_name;
            $paymentmethod->save();
            return redirect('paymentmethod')->with('message', 'Payment Method updated successfully!');
        }
        $paymentmethods = PaymentMethod::where('id',$paymentmethod_id)->first();
        return view('paymentmethods.update', ['paymentmethods' => $paymentmethods]);
    }
}
