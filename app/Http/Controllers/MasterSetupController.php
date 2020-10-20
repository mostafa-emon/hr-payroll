<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BankAccount;
use App\DeviceSetup;
use App\Designation;
use App\Department;
use App\Currency;
use App\Project;
use App\Branch;
use Auth;

class MasterSetupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function department_index() {
        $departments = Department::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.departments',compact('departments'));
    }

    public function department_add(Request $request) {
        $department = new Department;
        $department->company_id     = Auth::user()->company_id;
        $department->name           = $request->name;
        $department->department_id  = $request->department_id;
        $department->save();
        return redirect('departments')->with('message','Department Added Successfully!');
    }

    public function department_get($id) {
        $department = Department::where('id',$id)->first();
        echo $department;
    }

    public function department_update(Request $request,$id) {
        $department = Department::where('id',$id)->first();
        $department->name           = $request->name;
        $department->department_id  = $request->department_id;
        $department->save();
        return redirect('departments')->with('message','Department Updated Successfully!');
    }

    public function department_delete($id) {
        $department = Department::find($id);
        if($department->company_id == Auth::user()->company_id){
            $department->delete();
            return redirect('departments')->with('message','Department Deleted Successfully!');
        }else{
            return redirect('departments')->with('message','Do not try to be too smart!');
        }
    }

    public function designation_index() {
        $designations = Designation::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.designations',compact('designations'));
    }

    public function designation_add(Request $request) {
        $designation = new Designation;
        $designation->company_id     = Auth::user()->company_id;
        $designation->name           = $request->name;
        $designation->designation_id = $request->designation_id;
        $designation->save();
        return redirect('designations')->with('message','Designation Added Successfully!');
    }

    public function designation_get($id) {
        $designation = Designation::where('id',$id)->first();
        echo $designation;
    }

    public function designation_update(Request $request,$id) {
        $designation = Designation::where('id',$id)->first();
        $designation->name           = $request->name;
        $designation->designation_id = $request->designation_id;
        $designation->save();
        return redirect('designations')->with('message','Designation Updated Successfully!');
    }

    public function designation_delete($id) {
        $designation = Designation::find($id);
        if($designation->company_id == Auth::user()->company_id){
            $designation->delete();
            return redirect('designations')->with('message','Designation Deleted Successfully!');
        }else{
            return redirect('designations')->with('message','Do not try to be too smart!');
        }
    }


    public function project_index() {
        $projects = Project::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.projects',compact('projects'));
    }

    public function project_add(Request $request) {
        $project = new Project;
        $project->company_id    = Auth::user()->company_id;
        $project->name          = $request->name;
        $project->project_id    = $request->project_id;
        $project->address       = $request->address;
        $project->save();
        return redirect('projects')->with('message','Project Added Successfully!');
    }

    public function project_get($id) {
        $project = Project::where('id',$id)->first();
        echo $project;
    }

    public function project_update(Request $request,$id) {
        $project = Project::where('id',$id)->first();
        $project->name          = $request->name;
        $project->project_id    = $request->project_id;
        $project->address       = $request->address;
        $project->save();
        return redirect('projects')->with('message','Project Updated Successfully!');
    }

    public function project_delete($id) {
        $project = Project::find($id);
        if($project->company_id == Auth::user()->company_id){
            $project->delete();
            return redirect('projects')->with('message','Project Deleted Successfully!');
        }else{
            return redirect('projects')->with('message','Do not try to be too smart!');
        }
    }


    public function branch_index() {
        $branches = Branch::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.branches',compact('branches'));
    }

    public function branch_add(Request $request) {
        $branch = new Branch;
        $branch->company_id = Auth::user()->company_id;
        $branch->name       = $request->name;
        $branch->branch_id  = $request->branch_id;
        $branch->address    = $request->address;
        $branch->save();
        return redirect('branches')->with('message','Branch Added Successfully!');
    }

    public function branch_get($id) {
        $branch = Branch::where('id',$id)->first();
        echo $branch;
    }

    public function branch_update(Request $request,$id) {
        $branch = Branch::where('id',$id)->first();
        $branch->name       = $request->name;
        $branch->branch_id  = $request->branch_id;
        $branch->address    = $request->address;
        $branch->save();
        return redirect('branches')->with('message','Branch Updated Successfully!');
    }

    public function branch_delete($id) {
        $branch = Branch::find($id);
        if($branch->company_id == Auth::user()->company_id){
            $branch->delete();
            return redirect('branches')->with('message','Branch Deleted Successfully!');
        }else{
            return redirect('branches')->with('message','Do not try to be too smart!');
        }
    }


    public function currency_index() {
        $currencies = Currency::orderBy('id','asc')->paginate(10);
        return view('master_setup.currencies',compact('currencies'));
    }

    public function currency_add(Request $request) {
        $currency = new Currency;
        $currency->currency_name    = $request->currency_name;
        $currency->full_unit_name   = $request->full_unit_name;
        $currency->sub_unit_name    = $request->sub_unit_name;
        $currency->save();
        return redirect('currencies')->with('message','Currency Added Successfully!');
    }

    public function currency_get($id) {
        $currency = Currency::where('id',$id)->first();
        echo $currency;
    }

    public function currency_update(Request $request,$id) {
        $currency = Currency::where('id',$id)->first();
        $currency->currency_name    = $request->currency_name;
        $currency->full_unit_name   = $request->full_unit_name;
        $currency->sub_unit_name    = $request->sub_unit_name;
        $currency->save();
        return redirect('currencies')->with('message','Currency Updated Successfully!');
    }

    public function currency_delete($id) {
        $currency = Currency::find($id);
        $currency->delete();
        return redirect('currencies')->with('message','Currency Deleted Successfully!');
    }

    public function bank_account_index() {
        $banks = BankAccount::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.bank_accounts',compact('banks'));
    }

    public function bank_account_add(Request $request) {
        $bank = new BankAccount;
        $bank->company_id   = Auth::user()->company_id;
        $bank->name         = $request->name;
        $bank->account_no   = $request->account_no;
        $bank->account_type = $request->account_type;
        $bank->save();
        return redirect('bank-accounts')->with('message','Bank Account Added Successfully!');
    }

    public function bank_account_get($id) {
        $bank = BankAccount::where('id',$id)->first();
        echo $bank;
    }

    public function bank_account_update(Request $request,$id) {
        $bank = BankAccount::where('id',$id)->first();
        $bank->name         = $request->name;
        $bank->account_no   = $request->account_no;
        $bank->account_type = $request->account_type;
        $bank->save();
        return redirect('bank-accounts')->with('message','Bank Account Updated Successfully!');
    }

    public function bank_account_delete($id) {
        $bank = BankAccount::find($id);
        if($bank->company_id == Auth::user()->company_id){
            $bank->delete();
            return redirect('bank-accounts')->with('message','Bank Account Deleted Successfully!');
        }else{
            return redirect('bank-accounts')->with('message','Do not try to be too smart!');
        }
    }

    public function device_index() {
        $devices = DeviceSetup::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.device_setup',compact('devices'));
    }

    public function device_add(Request $request) {
        $device = new DeviceSetup;
        $device->company_id = Auth::user()->company_id;
        $device->name       = $request->name;
        $device->floor      = $request->floor;
        $device->ip_address = $request->ip_address;
        $device->serial_no  = $request->serial_no;
        $device->port       = $request->port;
        $device->brand      = $request->brand;
        $device->save();
        return redirect('device-setup')->with('message','Device Added Successfully!');
    }

    public function device_get($id) {
        $device = DeviceSetup::where('id',$id)->first();
        echo $device;
    }

    public function device_update(Request $request,$id) {
        $device = DeviceSetup::where('id',$id)->first();
        $device->name       = $request->name;
        $device->floor      = $request->floor;
        $device->ip_address = $request->ip_address;
        $device->serial_no  = $request->serial_no;
        $device->port       = $request->port;
        $device->brand      = $request->brand;
        $device->save();
        return redirect('device-setup')->with('message','Device Updated Successfully!');
    }

    public function device_delete($id) {
        $device = DeviceSetup::find($id);
        if($device->company_id == Auth::user()->company_id){
            $device->delete();
            return redirect('device-setup')->with('message','Device Deleted Successfully!');
        }else{
            return redirect('device-setup')->with('message','Do not try to be too smart!');
        }
    }
}
