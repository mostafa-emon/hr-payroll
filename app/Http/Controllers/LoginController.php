<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Company;

class LoginController extends Controller
{
    public function setLoginView(Request $request){
        if(Auth::check()){
            return redirect('/');
        }
        return view('auth.login');   
    }

    public function getLogin(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            
            if(Auth::user()->id != 1){
                $company = Company::select('companies.*','subscriptions.subscription_start_date','subscriptions.subscription_end_date')
                        ->join('subscriptions','subscriptions.id','companies.subscription_id')
                        ->where('companies.id',Auth::user()->company_id)
                        ->first();
                
                if($company->status == 0){
                    Auth::logout();
                    return redirect('/login')->with('error_message', 'Activation pending!');
                }else{
                    if($company->subscription_end_date < date('Y-m-d')){
                        Auth::logout();
                        return redirect('/login')->with('error_message', 'Subscription expired!');
                    }
                }
                
            }
        }
        return redirect('/login')->withErrors(['email'=> $request->email]);
    }

    public function OAuth(){
        return view('auth.OAuth');
    }
}
