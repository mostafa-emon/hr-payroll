<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index() {
        $info = Company::where('id',1)->first();
        return view('company.index', ['info' => $info]);
    }

    public function update(Request $request){
        $count = Company::where('id',1)->count();

        if($count == 0) {
            $company = new Company;
            $company->name      = $request->name;
            $company->phone     = $request->phone;
            $company->email     = $request->email;
            $company->address   = $request->address;
            $company->tin       = $request->tin;
            $company->vat_reg_no= $request->vat_reg_no;
            if ($request->hasFile('logo')) {
                $company->logo  = $request->file('logo')->store('logo');
            }
            $company->save();
        }else{
            $company = Company::where('id',1)->first();
            $company->name      = $request->name;
            $company->phone     = $request->phone;
            $company->email     = $request->email;
            $company->address   = $request->address;
            $company->tin       = $request->tin;
            $company->vat_reg_no= $request->vat_reg_no;
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
}
