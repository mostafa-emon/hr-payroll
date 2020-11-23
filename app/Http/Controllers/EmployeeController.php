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
use App\SalaryComponent;
use App\EmployeeEarningDeduction;
use App\PayrollInfo;
use App\LeaveType;
use App\LeaveInfo;
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

    public function add($page, $employee_id = "", Request $request){
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $banks                  = PayrollBank::where('company_id',Auth::user()->company_id)->orderby('bank_name','asc')->get();
        $earning_components     = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Earnings')->orderby('component_name','asc')->get();
        $deduction_components   = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Deduction')->orderby('component_name','asc')->get();
        $leave_types            = LeaveType::where('company_id',Auth::user()->company_id)->orderby('leave_name','asc')->get();
        return view('employee.add',compact('page','employee_id','departments','designations',
        'projects','branches','banks','earning_components','deduction_components','leave_types'));
    }

    public function add_personal_info(Request $request){
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

        return redirect('employee/add/employment/'.$employee->id)->with('message', 'Personal Information Saved Successfully!');
    }

    public function add_employment_info(Request $request){
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
            return redirect('employee/add/payroll/'.$request->employee_id)->with('message', 'Employment Information Saved Successfully!');
        }
    }

    public function add_payroll_info(Request $request){
        $earnings_row_count = count($request->salary_component_id);
        for($i = 0; $i < $earnings_row_count; $i++) {
            $earning = new EmployeeEarningDeduction();
            $earning->employee_id           = $request->employee_id;
            $earning->salary_component_id   = $request->salary_component_id[$i];
            $earning->earning_or_deduction  = 'earnings';
            $earning->fixed_or_percentage   = $request->fixed_or_percentage[$i];

            if($request->fixed_or_percentage[$i] != 'fixed'){
                $earning->percentage_amount     = $request->percentage_amount[$i];
                $earning->of_component_id       = $request->of_component_id[$i];
            }else{
                $earning->final_amount          = $request->final_amount[$i];
            }

            $earning->save();
        }

        $deductions_row_count = count($request->ded_salary_component_id);
        for($i = 0; $i < $deductions_row_count; $i++) {
            $deduction = new EmployeeEarningDeduction();
            $deduction->employee_id           = $request->employee_id;
            $deduction->salary_component_id   = $request->ded_salary_component_id[$i];
            $deduction->earning_or_deduction  = 'deductions';
            $deduction->fixed_or_percentage   = $request->ded_fixed_or_percentage[$i];

            if($request->ded_fixed_or_percentage[$i] != 'fixed'){
                $deduction->percentage_amount     = $request->ded_percentage_amount[$i];
                $deduction->of_component_id       = $request->ded_of_component_id[$i];
            }else{
                $deduction->final_amount          = $request->ded_final_amount[$i];
            }

            $deduction->save();
        }

        $info = new PayrollInfo();
        $info->employee_id                      = $request->employee_id;
        $info->company_pf_on_salary_statement   = $request->company_pf_on_salary_statement;
        $info->festival_bonus_per_festival      = $request->festival_bonus_per_festival;
        $info->gratuity_amount                  = $request->gratuity_amount;
        $info->investment_amount                = $request->investment_amount;
        $info->ot_allowed                       = $request->ot_allowed;
        $info->hourly_ot_rate                   = $request->hourly_ot_rate;
        $info->save();
        return redirect('employee/add/leave/'.$request->employee_id)->with('message', 'Payroll Information Saved Successfully!');
    }

    public function add_leave_info(Request $request){
        $leaves_row_count = count($request->leave_type_id);
        for($i = 0; $i < $leaves_row_count; $i++) {
            $leave = new LeaveInfo();
            $leave->employee_id             = $request->employee_id;
            $leave->leave_type_id           = $request->leave_type_id[$i];
            $leave->yearly_allotment        = $request->yearly_allotment[$i];
            $leave->opening_balance_date    = date('Y-m-d',strtotime( $request->opening_balance_date[$i] ));
            $leave->opening_balance         = $request->opening_balance[$i];
            $leave->carry_forward           = $request->carry_forward[$i];
            $leave->max_carry_forward       = $request->max_carry_forward[$i];
            $leave->save();
        }
        return redirect('employee')->with('message', 'Employee Added Successfully!');
    }
}
