<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmploymentInfo;
use App\Department;
use App\Designation;
use App\Project;
use App\Branch;
use App\PayrollBank;
use Auth;
use Redirect;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $employees = Employee::where('company_id',Auth::user()->company_id)->paginate(10);
        return view('employee.index',compact('employees'));
    }

    public function add(Request $request){
        $departments = Department::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $designations = Designation::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $projects = Project::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $branches = Branch::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $banks    = PayrollBank::where('company_id',Auth::user()->company_id)->orderby('bank_name','asc')->get();

        if($request->name != "") {
            $employee = new Employee;
            $employee->company_id    = Auth::user()->company_id;
            $employee->name                     = $request->name;
            $employee->employee_id              = $request->employee_id;
            $employee->fathers_name             = $request->fathers_name;
            $employee->mothers_name             = $request->mothers_name;
            $employee->spouse_name              = $request->spouse_name;
            $employee->present_address          = $request->present_address;
            $employee->permanent_address        = $request->permanent_address;
            $employee->date_of_birth            = $request->date_of_birth;
            $employee->gender                   = $request->gender;
            $employee->marital_status           = $request->marital_status;
            $employee->religion                 = $request->religion;
            $employee->blood_group              = $request->blood_group;
            $employee->nationality              = $request->nationality;
            $employee->nid_number               = $request->nid_number;
            $employee->passport_number          = $request->passport_number;
            $employee->tin_no                   = $request->tin_no;
            $employee->phone_1                  = $request->phone_1;
            $employee->phone_2                  = $request->phone_2;
            $employee->emergency_contact_person = $request->emergency_contact_person;
            $employee->emergency_phone_number   = $request->emergency_phone_number;
            $employee->email_address            = $request->email_address;
            $employee->reference_1              = $request->reference_1;
            $employee->reference_2              = $request->reference_2;

            if($request->hasFile('employee_photo')){  
                $employee->employee_photo       = $request->file('employee_photo')->store('employees');
            }
            if($request->hasFile('employee_cv')){  
                $employee->employee_cv          = $request->file('employee_cv')->store('employees');
            }

            $employee->save();
            return view('employee.add',compact('departments','designations','projects','branches','banks','employee'));
        }
        return view('employee.add',compact('departments','designations','projects','branches','banks'));
    }

    public function employment_info(Request $request){
        if($request->employee_id != "") {
            $employee = new EmploymentInfo;
            $employee->employee_id              = $request->employee_id;
            $employee->department_id            = $request->department_id;
            $employee->designation_id           = $request->designation_id;
            $employee->project_id               = $request->project_id;
            $employee->branch_id                = $request->branch_id;
            $employee->date_of_joining          = date('Y-m-d',strtotime($request->date_of_joining));
            $employee->date_of_confirmation     = date('Y-m-d',strtotime($request->date_of_confirmation));
            $employee->date_of_resign           = date('Y-m-d',strtotime($request->date_of_resign));
            $employee->current_status           = $request->current_status;
            $employee->reason_for_resign        = $request->reason_for_resign;
            $employee->terminated               = $request->terminated;
            $employee->date_of_termination      = date('Y-m-d',strtotime($request->date_of_termination));
            $employee->reason_for_termination   = $request->reason_for_termination;
            $employee->duty_type                = $request->duty_type;
            $employee->salary_payment_method    = $request->salary_payment_method;
            $employee->bank_account_no          = $request->bank_account_no;
            $employee->bank_name                = $request->bank_name;
            $employee->pay_slip_send_method     = $request->pay_slip_send_method;
            $employee->weekend_1                = $request->weekend_1;
            $employee->weekend_2                = $request->weekend_2;
            $employee->save();
            return redirect('employee')->with('message', 'Employee Added Successfully!');
        }
    }
}
