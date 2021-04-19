<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Subscription;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\User;
use App\Role;
use App\Currency;
use Hash;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $info = Company::where('id',Auth::user()->company_id)->first();
        $currency = Currency::orderby('currency_name','asc')->get();
        return view('company.index',compact('currency','info'));
    }

    public function update(Request $request){
        $count = Company::where('id',Auth::user()->company_id)->count();

        if($count == 0) {
            if(roles() != "" && !in_array(1, json_decode(roles(),false))){
                return redirect('404');
            }
            $company = new Company;
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
            if ($request->hasFile('logo')) {
                $company->logo  = $request->file('logo')->store('logo');
            }
            $company->save();
        }else{
            if(roles() != "" && !in_array(1, json_decode(roles(),false))){
                return redirect('404');
            }
            $company = Company::where('id',Auth::user()->company_id)->first();
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
            if ($request->hasFile('logo')) {
                if($company->logo != ""){
                    Storage::delete($company->logo);
                }
                $company->logo  = $request->file('logo')->store('logo');
            }
            $company->save();
        }
        return redirect('company')->with('message','Profile updated successfully!');
    }

    public function company_list(){
        $company = Company::select('companies.*','subscriptions.amount','subscriptions.subscription_start_date','subscriptions.subscription_end_date')
                ->join('subscriptions','subscriptions.id','companies.subscription_id')
                ->orderBy('name','asc')
                ->get();
        return view('company_list', ['companies' => $company]);
    }

    public function active($company_id){
        Company::where('id',$company_id)->update(['status' => 1]);
        return redirect('subscription')->with('message', 'Company is active now!');
    }

    public function inactive($company_id){
        Company::where('id',$company_id)->update(['status' => 0]);
        return redirect('subscription')->with('message', 'Company is inactive now!');;
    }

    public function renew($company_id, Request $request){
        $subscription = new Subscription();
        $subscription->amount = $request->amount;
        $subscription->subscription_start_date  = date('Y-m-d',strtotime($request->subscription_start_date));
        $subscription->subscription_end_date    = date('Y-m-d',strtotime($request->subscription_end_date));
        $subscription->save();
        Company::where('id',$company_id)->update(['subscription_id' => $subscription->id]);
        return redirect('subscription')->with('message', 'Renew Successful!');
    }

    public function emailReset($company_id, Request $request) {
        $user = User::where('company_id',$company_id)->where('roles',2)->first();
        $user->email = $request->login_email;
        $user->save();
        return redirect('subscription')->with('message', 'Email reset Successful!');
    }

    public function passwordReset($company_id, Request $request) {
        $password = Hash::make($request->password);
        $user = User::where('company_id',$company_id)->where('roles',2)->first();
        $user->password = $password;
        $user->save();
        return redirect('subscription')->with('message', 'Password reset Successful!');
    }

    public function subscriptionDelete($company_id) {
        $company = Company::where('id',$company_id)->first();
        Company::where('id',$company_id)->delete();
        Role::where('company_id',$company_id)->delete();
        User::where('company_id',$company_id)->delete();

        return redirect('subscription')->with('message', 'Subscription deleted Successfully!');
    }

    public function subscriptionUpdate($company_id,Request $request) {
        $company_info       = Company::where('id',$company_id)->first();
        $subcription_info   = Subscription::where('id',$company_info->subscription_id)->first();
        $login_info         = User::where('company_id',$company_id)->where('roles',2)->first();
        $currency           = Currency::orderby('currency_name','asc')->get();

        if($request->name !=""){
            $subscription = Subscription::where('id',$subcription_info->id)->first();
            $subscription->amount                    = $request->subscription_amount;
            $subscription->subscription_start_date   = date('Y-m-d',strtotime($request->subscription_start_date));
            $subscription->subscription_end_date     = date('Y-m-d',strtotime($request->subscription_end_date));
            $subscription->save();

            $company = Company::where('id',$company_id)->first();
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
                if($company->logo != ""){
                    Storage::delete($company->logo);
                }
                $company->logo  = $request->file('logo')->store('logo');
            }
            $company->save();

            $user = User::where('id',$login_info->id)->first();
            $user->company_id                   = $company->id;
            $user->name                         = $request->name;
            $user->designation                  = "Admin";
            $user->email                        = $request->login_email;
            if($request->password != ""){
                $user->password                     = Hash::make($request->login_password);
            }
            $user->save();

            return redirect('subscription')->with('message', 'Subscription Updated Successfully');
        }
        return view('subscription_update',compact('currency','company_info','subcription_info','login_info'));
    }
}
