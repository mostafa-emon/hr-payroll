<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;
use App\Subscription;
use App\Setting;
use Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function register(Request $request){
        if($request->name !=""){
            $subscription = new Subscription();
            $subscription->amount                    = $request->subscription_amount;
            $subscription->subscription_start_date   = date('Y-m-d',strtotime($request->subscription_start_date));
            $subscription->subscription_end_date     = date('Y-m-d',strtotime($request->subscription_end_date));
            $subscription->save();

            $company = new Company();
            $company->name                   = $request->name;
            $company->address                = $request->address;
            $company->phone                  = $request->phone;
            $company->email                  = $request->email;
            $company->tin                    = $request->tin;
            $company->vat_reg_no             = $request->vat_reg_no;
            $company->status                 = 1;
            $company->subscription_id        = $subscription->id;

            $company->qb_client_id           = $request->qb_client_id;
            $company->qb_client_secret       = $request->qb_client_secret;
            $company->qb_company_id          = $request->qb_company_id;
            $company->qb_environment         = $request->qb_environment;

            if ($request->hasFile('logo')) {
                $company->logo  = $request->file('logo')->store('logo');
            }
            $company->save();

            $user = new User();
            $user->company_id   = $company->id;
            $user->name         = $request->name;
            $user->designation  = "Admin";
            $user->email        = $request->login_email;
            $user->password     = Hash::make($request->login_password);
            $user->roles        = 2;
            $user->save();

            $setting = new Setting();
            $setting->company_id            = $company->id;
            $setting->voucher_number        = 'auto';
            $setting->voucher_size          = 'half_page';
            $setting->mr_number             = 'auto';
            $setting->mr_size               = 'full_page';
            $setting->amount_in_word_format = 'crore_lakh_thousand';
            $setting->approval_for_mr       = 1;
            $setting->approval_for_cheque   = 1;
            $setting->save();

            return redirect('subscription')->with('message', 'Registration successful');
        }
        return view('register');
    }
}
