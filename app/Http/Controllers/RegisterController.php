<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;
use Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function register(Request $request){
        if($request->name !=""){
            $company = new Company();
            $company->name                   = $request->name;
            $company->address                = $request->address;
            $company->phone                  = $request->phone;
            $company->email                  = $request->email;
            $company->tin                    = $request->tin;
            $company->vat_reg_no             = $request->vat_reg_no;
            $company->subscription_end_date  = date('Y-m-d',strtotime($request->subscription_end_date));
            $company->status                 = 1;
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
            $user->roles        = 1;
            $user->save();

            return redirect('subscription')->with('message', 'Your Registration is kept for Admin Review');
        }
        return view('register');
    }
}
