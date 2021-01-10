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
use App\PayrollBranch;
use App\Currency;
use App\User;
use Auth;
use Hash;
use Redirect;
use Storage;

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
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderby('id','asc')->get();
        return view('employee.add',compact('page','employee_id','departments','designations','currencies',
        'projects','branches','banks','earning_components','deduction_components','leave_types'));
    }

    public function add_personal_info(Request $request){
        $find_employee = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$request->employee_id)->first();
        if($find_employee != "") {
            return redirect('employee/add/personal')->with('error_message', 'This Employee ID is already Used!');
        }

        $employee = new Employee;
        $employee->company_id               = Auth::user()->company_id;
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
            $employee->bank_branch_id           = $request->bank_branch_id;
            $employee->pay_slip_send_method     = $request->pay_slip_send_method;
            $employee->weekend_1                = $request->weekend_1;
            $employee->weekend_2                = $request->weekend_2;
            $employee->id_in_biometric_machine  = $request->id_in_biometric_machine;
            $employee->save();

            $personal_info = Employee::where('id',$request->employee_id)->first();
            $user = new User;
            $user->company_id                   = Auth::user()->company_id;
            $user->employee_id                  = $request->employee_id;
            $user->name                         = $personal_info->name;

            $designation_info                   = Designation::where('id',$employee->designation_id)->first();
            if($designation_info != ""){
                $user->designation              = $designation_info->name;
            }

            $user->email                        = $personal_info->email_address;
            $user->password                     = Hash::make($personal_info->phone_1);
            $user->avatar                       = $personal_info->employee_photo;

            if($employee->current_status == "Active") {
                $user->status                   = 1;
            }else{
                $user->status                   = 0;
            }
            
            $user->save();

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

                $component_amount = EmployeeEarningDeduction::where('employee_id',$request->employee_id)->where('salary_component_id',$earning->of_component_id)->first();
                if($component_amount != "" && $component_amount->final_amount) {
                    $earning->final_amount      = ($earning->percentage_amount / 100) * $component_amount->final_amount;
                }
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
                
                $component_amount = EmployeeEarningDeduction::where('employee_id',$request->employee_id)->where('salary_component_id',$deduction->of_component_id)->first();
                if($component_amount != "" && $component_amount->final_amount) {
                    $deduction->final_amount      = ($deduction->percentage_amount / 100) * $component_amount->final_amount;
                }
            }else{
                $deduction->final_amount          = $request->ded_final_amount[$i];
            }

            $deduction->save();
        }

        $info = new PayrollInfo();
        $info->employee_id                          = $request->employee_id;
        $info->company_pf_on_salary_statement       = $request->company_pf_on_salary_statement;
        $info->festival_bonus_per_festival          = $request->festival_bonus_per_festival;
        $info->gratuity_amount                      = $request->gratuity_amount;
        $info->investment_amount                    = $request->investment_amount;
        $info->ot_allowed                           = $request->ot_allowed;
        $info->hourly_ot_rate                       = $request->hourly_ot_rate;
        $info->currency_id                          = $request->currency_id;
        $info->mark_overtime_if_work_in_holiday     = $request->mark_overtime_if_work_in_holiday;
        $info->mark_overtime_if_work_in_leave_day   = $request->mark_overtime_if_work_in_leave_day;
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
        $personal_info = Employee::where('id',$request->employee_id)->first();
        $personal_info->leave_count_from = $request->leave_count_from;
        $personal_info->save();

        return redirect('employee')->with('message', 'Employee Added Successfully!');
    }

    public function delete($id) {
        $employee = Employee::find($id);
        if($employee->company_id == Auth::user()->company_id){
            $employee->delete();
            return redirect('employee')->with('message','Employee Deleted Successfully!');
        }else{
            return redirect('employee')->with('message','Do not try to be too smart!');
        }
    }

    public function update($page, $employee_id, Request $request){
        $employee               = Employee::where('id',$employee_id)->first();
        $employment_info        = EmploymentInfo::where('employee_id',$employee_id)->first();
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $banks                  = PayrollBank::where('company_id',Auth::user()->company_id)->orderby('bank_name','asc')->get();
        if($employment_info != "" && $employment_info->bank_name != "") {
            $bank_branches      = PayrollBranch::where('bank_id',$employment_info->bank_name)->orderby('branch_name','asc')->get();
        }else{
            $bank_branches      = [];
        }
        $earning_components     = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Earnings')->orderby('component_name','asc')->get();
        $deduction_components   = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Deduction')->orderby('component_name','asc')->get();
        $leave_types            = LeaveType::where('company_id',Auth::user()->company_id)->orderby('leave_name','asc')->get();

        //Payroll Info
        $earnings               = EmployeeEarningDeduction::where('employee_id',$employee_id)->where('earning_or_deduction','earnings')->get();
        $deductions             = EmployeeEarningDeduction::where('employee_id',$employee_id)->where('earning_or_deduction','deductions')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderby('id','asc')->get();
        $payroll_info           = PayrollInfo::where('employee_id',$employee_id)->first();

        //Leave Info
        $leaves                 = LeaveInfo::where('employee_id',$employee_id)->get();

        if($employment_info == "") { $info_id = ""; } else { $info_id = $employment_info->id; }
        return view('employee.update.update',compact('page','employee_id','departments','designations','info_id','currencies',
        'projects','branches','banks','earning_components','deduction_components','leave_types','employee','employment_info','earnings','deductions','payroll_info','leaves','bank_branches'));
    }

    public function update_personal_info($employee_id,Request $request){
        $find_employee = Employee::where('company_id',Auth::user()->company_id)->where('id','!=',$employee_id)->where('employee_id',$request->employee_id)->first();
        if($find_employee != "") {
            return redirect('employee/update/personal/'.$employee_id)->with('error_message', 'This Employee ID is already Used!');
        }

        $employee = Employee::where('id',$employee_id)->first();
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
            if($employee->employee_photo != ""){
                Storage::delete($employee->employee_photo);
            }
            $employee->employee_photo       = $request->file('employee_photo')->store('employees');
        }
        if($request->hasFile('employee_cv')){
            if($employee->employee_cv != ""){
                Storage::delete($employee->employee_cv);
            }
            $employee->employee_cv          = $request->file('employee_cv')->store('employees');
        }

        $employee->save();

        return redirect('employee/update/employment/'.$employee->id)->with('message', 'Personal Information Updated Successfully!');
    }

    public function update_employment_info($info_id = "",Request $request){
        if($request->employee_id != "") {
            if($info_id == ""){
                $employee = new EmploymentInfo;
            }else{
                $employee = EmploymentInfo::where('id',$info_id)->first();
            }
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
            $employee->bank_branch_id           = $request->bank_branch_id;
            $employee->pay_slip_send_method     = $request->pay_slip_send_method;
            $employee->weekend_1                = $request->weekend_1;
            $employee->weekend_2                = $request->weekend_2;
            $employee->id_in_biometric_machine  = $request->id_in_biometric_machine;
            $employee->save();
            return redirect('employee/update/payroll/'.$request->employee_id)->with('message', 'Employment Information Updated Successfully!');
        }
    }

    public function update_payroll_info($employee_id = "",Request $request){
        if($request->employee_id != "") {
            $preDataCount = EmployeeEarningDeduction::where('employee_id',$employee_id)->count();
            if($preDataCount != 0 && $preDataCount != "") {
                EmployeeEarningDeduction::where('employee_id',$employee_id)->delete();
            }

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

                    $component_amount = EmployeeEarningDeduction::where('employee_id',$request->employee_id)->where('salary_component_id',$earning->of_component_id)->first();
                    if($component_amount != "" && $component_amount->final_amount) {
                        $earning->final_amount      = ($earning->percentage_amount / 100) * $component_amount->final_amount;
                    }
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

                    $component_amount = EmployeeEarningDeduction::where('employee_id',$request->employee_id)->where('salary_component_id',$deduction->of_component_id)->first();
                    if($component_amount != "" && $component_amount->final_amount) {
                        $deduction->final_amount      = ($deduction->percentage_amount / 100) * $component_amount->final_amount;
                    }
                }else{
                    $deduction->final_amount          = $request->ded_final_amount[$i];
                }
    
                $deduction->save();
            }

            $count_payroll_info = PayrollInfo::where('employee_id',$employee_id)->count();
            if($count_payroll_info == 0){
                $info = new PayrollInfo;
            }else{
                $info = PayrollInfo::where('employee_id',$employee_id)->first();
            }
            $info->employee_id                          = $request->employee_id;
            $info->company_pf_on_salary_statement       = $request->company_pf_on_salary_statement;
            $info->festival_bonus_per_festival          = $request->festival_bonus_per_festival;
            $info->gratuity_amount                      = $request->gratuity_amount;
            $info->investment_amount                    = $request->investment_amount;
            $info->ot_allowed                           = $request->ot_allowed;
            $info->hourly_ot_rate                       = $request->hourly_ot_rate;
            $info->currency_id                          = $request->currency_id;
            $info->mark_overtime_if_work_in_holiday     = $request->mark_overtime_if_work_in_holiday;
            $info->mark_overtime_if_work_in_leave_day   = $request->mark_overtime_if_work_in_leave_day;
            $info->save();
            return redirect('employee/update/leave/'.$request->employee_id)->with('message', 'Payroll Information Updated Successfully!');
        }
    }

    public function update_leave_info($employee_id = "",Request $request){
        if($request->employee_id != "") {
            $preDataCount = LeaveInfo::where('employee_id',$employee_id)->count();
            if($preDataCount != 0 && $preDataCount != "") {
                LeaveInfo::where('employee_id',$employee_id)->delete();
            }
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

            $personal_info = Employee::where('id',$employee_id)->first();
            $personal_info->leave_count_from = $request->leave_count_from;
            $personal_info->save();

            return redirect('employee')->with('message', 'Employee Updated Successfully!');
        }
    }

    public function search_employee($department_id,$project_id="",$branch_id="") {
        $employees   = EmploymentInfo::orderBy('employment_infos.id','asc')
                    ->join('employees','employees.id','employment_infos.employee_id')
                    ->where('employees.company_id',Auth::user()->company_id);
        if($department_id != "" && $department_id != 0){
            $employees    = $employees->where('department_id',$department_id);
        }

        if($project_id != "" && $project_id != 0){
            $employees   = $employees->where('project_id',$project_id);
        }

        if($branch_id != "" && $branch_id != 0){
            $employees   = $employees->where('branch_id',$branch_id);
        }
        $employees = $employees->get();

        if(count($employees) > 0) {
            foreach($employees as $employee) {
                echo "<option value=".$employee->employee_id.">".$employee->name."</option>";
            }
        }else {
            echo "";
        }
    }

    public function search_employee_increment_id($department_id,$project_id="",$branch_id="",$component_id="") {

        //$earnings    = EmployeeEarningDeduction::where('earning_or_deduction','earnings')->get();
        $employees   = EmploymentInfo::orderBy('employment_infos.id','asc')
                    ->join('employees','employees.id','employment_infos.employee_id')
                    ->where('employees.company_id',Auth::user()->company_id);
                    
        if($department_id != "" && $department_id != 0){
            $employees    = $employees->where('department_id',$department_id);
        }

        if($project_id != "" && $project_id != 0){
            $employees   = $employees->where('project_id',$project_id);
        }

        if($branch_id != "" && $branch_id != 0){
            $employees   = $employees->where('branch_id',$branch_id);
        }

        if($component_id != "" && $component_id != 0){
            $is_exists    = EmployeeEarningDeduction::where('salary_component_id',$component_id)->get();
            $earning_employee = [];
            foreach($is_exists as $earning) {
                $earning_employee[] = $earning->employee_id;
            }
            $employees = $employees->whereIn('employees.id',$earning_employee);
        }

        $employees = $employees->get();

        if(count($employees) > 0) {
            foreach($employees as $employee) {
                echo "<option value=".$employee->id.">".$employee->name."</option>";
            }
        }else {
            echo "";
        }
    }
}