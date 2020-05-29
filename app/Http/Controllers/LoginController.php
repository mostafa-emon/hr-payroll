<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Audit;
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
            
            $company = Company::where('id',Auth::user()->company_id)->first();
            if($company->status == 0){
                Auth::logout();
                return redirect('/login')->with('error_message', 'Activation pending!');
            }else{
                if($company->subscription_end_date < date('Y-m-d')){
                    Auth::logout();
                    return redirect('/login')->with('error_message', 'Subscription expired!');
                }
            }

            $old_values = []; $new_values = [];
            $audit = new Audit();
            $audit->user_type = "App\User";
            $audit->auditable_id = 11;
            $audit->auditable_type = "App\User";
            $audit->event = "Logged In";
            $audit->url = request()->fullUrl();
            $audit->ip_address = request()->getClientIp();
            $audit->user_agent = request()->userAgent();
            $audit->created_at = Carbon::now();
            $audit->updated_at = Carbon::now();
            $audit->user_id = Auth::user()->id;
            $audit->old_values = json_encode($old_values);
            $audit->new_values = json_encode($new_values);
            $audit->save();

            return redirect('/');
        }
        return redirect('/login')->withErrors(['email'=> $request->email]);
    }
}
