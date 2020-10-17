<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;
use App\Subscription;
use App\Role;
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
            $company->name                      = $request->name;
            $company->address                   = $request->address;
            $company->phone                     = $request->phone;
            $company->email                     = $request->email;
            $company->tin                       = $request->tin;
            $company->vat_reg_no                = $request->vat_reg_no;
            $company->status                    = 1;
            $company->subscription_id           = $subscription->id;

            if ($request->hasFile('logo')) {
                $company->logo  = $request->file('logo')->store('logo');
            }
            $company->save();

            $user = new User();
            $user->company_id                   = $company->id;
            $user->name                         = $request->name;
            $user->designation                  = "Admin";
            $user->email                        = $request->login_email;
            $user->password                     = Hash::make($request->login_password);
            $user->roles                        = 2;
            $user->save();

            $access = [];
            for($i=1; $i<=88; $i++){
                $access[] = $i;
            }
            $role = new Role();
            $role->company_id               = $company->id;
            $role->role_name                = "Admin";
            $role->access                   = json_encode($access);
            $role->save();

            $access = [];
            for($a=1; $a<=83; $a++){
                if($a==1) {continue;} elseif($a==5) {continue;} elseif($a==6) {continue;} elseif($a==7) {continue;} elseif($a==23) {continue;} elseif($a==24) {continue;} elseif($a==25) {continue;} elseif($a==29) {continue;} elseif($a==30) {continue;} elseif($a==31) {continue;}
                $access[] = $a;
            }
            $role = new Role();
            $role->company_id               = $company->id;
            $role->role_name                = "User";
            $role->access                   = json_encode($access);
            $role->save();

            return redirect('subscription')->with('message', 'Registration successful');
        }
        return view('register');
    }
}
