<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;
use App\Subscription;
use App\Role;
use App\Currency;
use App\GeneralSetting;
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
            $company->phone                     = $request->phone;
            $company->fax                       = $request->fax;
            $company->email                     = $request->email;
            $company->address_line_1            = $request->address_line_1;
            $company->address_line_2            = $request->address_line_2;
            $company->bin                       = $request->bin;
            $company->tin                       = $request->tin;
            $company->ein                       = $request->ein;
            $company->vat_reg_no                = $request->vat_reg_no;
            $company->website                   = $request->website;
            $company->leave_year_from           = $request->leave_year_from;
            $company->leave_year_to             = $request->leave_year_to;
            $company->status                    = 1;
            $company->subscription_id           = $subscription->id;

            if($request->attendance == 1) { $company->attendance = 1; }else { $company->attendance = 0; }
            if($request->leave == 1) { $company->leave = 1; }else { $company->leave = 0; }
            if($request->payroll == 1) { $company->payroll = 1; }else { $company->payroll = 0; }
            if($request->document_upload == 1) { $company->document_upload = 1; }else { $company->document_upload = 0; }
            if($request->quickbooks == 1) { $company->quickbooks = 1; }else { $company->quickbooks = 0; }

            $company->employee_limit         = $request->employee_limit;
            $company->qb_client_id           = $request->qb_client_id;
            $company->qb_client_secret       = $request->qb_client_secret;
            $company->qb_company_id          = $request->qb_company_id;
            $company->qb_environment         = $request->qb_environment;

            $company->biometric_machine_redirect_url = $request->biometric_machine_redirect_url;
            if ($request->hasFile('logo')) {
                $company->logo  = $request->file('logo')->store('logo');
            }
            $company->save();

            //Users
            $user = new User();
            $user->company_id                   = $company->id;
            $user->name                         = $request->name;
            $user->designation                  = "Admin";
            $user->email                        = $request->login_email;
            $user->password                     = Hash::make($request->login_password);
            $user->roles                        = 2;
            $user->save();

            //Roles
            /*$access = [];
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
            $role->save();*/

            //General Setting
            $setting = new GeneralSetting;
            $setting->company_id            = $company->id;
            $setting->amount_in_word        = "Crore-Lakh-Thousand";
            $setting->date_format           = "DD-MM-YYYY";
            $setting->save();

            //Currency
            $currency = new Currency();
            $currency->company_id           = $company->id;
            $currency->currency_name        = "Bangladeshi Taka";
            $currency->full_unit_name       = "Taka";
            $currency->sub_unit_name        = "Paisa";
            $currency->default              = 1;
            $currency->save();

            $currency = new Currency();
            $currency->company_id           = $company->id;
            $currency->currency_name        = "US Dollar";
            $currency->full_unit_name       = "USD";
            $currency->sub_unit_name        = "Cent";
            $currency->default              = 0;
            $currency->save();

            return redirect('subscription')->with('message', 'Registration successful');
        }
        $currency = Currency::orderby('currency_name','asc')->get();
        return view('register',compact('currency'));
    }
}
