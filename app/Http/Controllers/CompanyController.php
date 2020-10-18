<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Subscription;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\User;
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
            $company->currency_id               = $request->currency_id;
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
            $company->currency_id               = $request->currency_id;
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
}
