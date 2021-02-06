<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalaryComponent;
use App\Company;
use Auth;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function component_index() {
        $salaries = SalaryComponent::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->paginate(10);
        $company  = Company::where('id',Auth::user()->company_id)->first();
        return view('payroll_setup.salary_component.index',compact('salaries','company'));
    }

    public function component_add(Request $request) {
        if($request->component_name !=""){
            $salary = new SalaryComponent;
            $salary->company_id                 = Auth::user()->company_id;
            $salary->component_type             = $request->component_type;
            $salary->component_name             = $request->component_name;
            if($request->component_type == "Earnings"){
                $salary->component_reference    = $request->reference_1;
            }else{
                $salary->component_reference    = $request->reference_2;
            }
            $salary->quickbooks_ledger          = $request->quickbooks_ledger;
            $salary->save();
            return redirect('salary-components')->with('message','Salary Component Added Successfully!');
        }
        $company  = Company::where('id',Auth::user()->company_id)->first();
        return view('payroll_setup.salary_component.add',compact('company'));
    }

    public function component_update(Request $request,$id) {
        $company    = Company::where('id',Auth::user()->company_id)->first();
        $salary     = SalaryComponent::where('id',$id)->first();
        if($salary->company_id == Auth::user()->company_id) {
            if($request->component_name !=""){
                $salary = SalaryComponent::where('id',$id)->first();
                $salary->component_type             = $request->component_type;
                $salary->component_name             = $request->component_name;
                if($request->component_type == "Earnings"){
                    $salary->component_reference    = $request->reference_1;
                }else{
                    $salary->component_reference    = $request->reference_2;
                }
                $salary->quickbooks_ledger          = $request->quickbooks_ledger;
                $salary->save();
                return redirect('salary-components')->with('message','Salary Component Updated Successfully!');
            }
            return view('payroll_setup.salary_component.update',compact('salary','company'));
        }else{
            return redirect('salary-components')->with('message','Do not try to be too smart!');
        }
    }

    public function component_delete($id) {
        $salary = SalaryComponent::find($id);
        if($salary->company_id == Auth::user()->company_id){
            $salary->delete();
            return redirect('salary-components')->with('message','Salary Component Deleted Successfully!');
        }else{
            return redirect('salary-components')->with('message','Do not try to be too smart!');
        }
    }

    public function component_reference($component_id) {
        echo SalaryComponent::where('id',$component_id)->first()->component_reference;
    }
}
