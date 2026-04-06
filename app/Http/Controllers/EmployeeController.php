<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmploymentInfo;
use App\Designation;
use App\Department;
use App\Vertical;
use App\Section;
use App\JobLevel;
use App\PayrollBank;
use App\SalaryComponent;
use App\EmployeeEarningDeduction;
use App\PayrollInfo;
use App\PayrollBranch;
use App\Currency;
use App\User;
use App\Company;
use App\TaxRule;
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
        if(roles() != "" && !in_array(22, json_decode(roles(),false))){
            return redirect('404');
        }
        $employees = Employee::where('company_id',Auth::user()->company_id)->paginate(10);
        return view('employee.index',compact('employees'));
    }

    public function add(Request $request, $page, $employee_id = ""){
        if(roles() != "" && !in_array(23, json_decode(roles(),false))){
            return redirect('404');
        }
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $banks                  = PayrollBank::where('company_id',Auth::user()->company_id)->orderby('bank_name','asc')->get();
        $earning_components     = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Earnings')->orderby('component_name','asc')->get();
        $deduction_components   = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Deduction')->orderby('component_name','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderby('id','asc')->get();
        $default_currency       = Currency::where('default',1)->where('company_id',Auth::user()->company_id)->first();
        return view('employee.add',compact('page','employee_id','departments','designations','currencies',
        'banks','earning_components','deduction_components','default_currency'));
    }

    public function add_personal_info(Request $request){
        $employee_limit = Company::where('id',Auth::user()->company_id)->first()->employee_limit;
        $count_active_employee = Employee::join('employment_infos','employees.id','employment_infos.employee_id')->where('company_id',Auth::user()->company_id)->where('current_status','Active')->count();
        if($count_active_employee >= $employee_limit) {
            return redirect('employee')->with('error_message', 'Employee limit Exceed!');
        }

        $find_employee = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$request->employee_id)->first();
        if($find_employee != "") {
            return redirect('employee/add/personal')->with('error_message', 'This Employee ID is already Used!');
        }

        /*$email_validation = User::where('email',$request->email_address)->first();
        if($email_validation != "") {
            return redirect('employee/add/personal')->with('error_message', 'This Email is already Used!');
        }*/

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
        /*if($request->hasFile('employee_cv')){  
            $employee->employee_cv          = $request->file('employee_cv')->store('employees');
        }*/

        if($request->hasFile('employee_cv'))
        {
            $cv = [];
            foreach($request->file('employee_cv') as $file)
            {
                $filesize = filesize($file);
                $filesize_in_kb = $filesize / 1024;
                if($filesize_in_kb <= 2048) {
                    $custom_name    = md5(uniqid(rand(), true)).$employee->company_id.'.'.$file->getClientOriginalExtension();
                    $file->move('storage/employees/', $custom_name);
                    array_push($cv, $custom_name);
                }
            }
            $employee->employee_cv = json_encode($cv);
        }else{
            $employee->employee_cv = '[]';
        }

        $employee->save();

        if($request->employee_id =='') {
            $employee->employee_id          = 1000 + $employee->id;
            $employee->save();
        }

        return redirect('employee/add/employment/'.$employee->id)->with('message', 'Personal Information Saved Successfully!');
    }

    public function add_employment_info(Request $request){
        if($request->employee_id != "") {
            $employee = new EmploymentInfo;
            $employee->employee_id              = $request->employee_id;
            $employee->department_id            = $request->department_id;
            $employee->designation_id           = $request->designation_id;
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
            /*$user = new User;
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
            
            $user->save();*/

            return redirect('employee/add/payroll/'.$request->employee_id)->with('message', 'Employment Information Saved Successfully!');
        }
    }

    public function add_payroll_info(Request $request){
        $earnings_row_count = count($request->salary_component_id);
        //return response()->json($request->salary_component_id);
        if($request->salary_component_id !=[null]) {

            for($i = 0; $i < $earnings_row_count; $i++) {
                if($request->salary_component_id[$i] != "") {
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
            }

        }

        $deductions_row_count = count($request->ded_salary_component_id);
        if($request->ded_salary_component_id !=[null]) {

            for($i = 0; $i < $deductions_row_count; $i++) {
                if($request->ded_salary_component_id[$i] != "") {
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
            }

        }

        $info = new PayrollInfo();
        $info->employee_id                          = $request->employee_id;
        $info->festival_bonus_per_festival          = $request->festival_bonus_per_festival;
        $info->gratuity_amount                      = $request->gratuity_amount;
        $info->gratuity_opening_balance             = $request->gratuity_opening_balance;
        $info->company_pf_opening_balance           = $request->company_pf_opening_balance;
        $info->employee_pf_opening_balance          = $request->employee_pf_opening_balance;
        $info->investment_amount                    = $request->investment_amount;
        $info->ot_allowed                           = $request->ot_allowed;
        $info->hourly_ot_rate                       = $request->hourly_ot_rate;
        $info->currency_id                          = $request->currency_id;
        $info->save();
        return redirect('employee')->with('message', 'Employee Added Successfully!');
    }


    public function delete($id) {
        if(roles() != "" && !in_array(25, json_decode(roles(),false))){
            return redirect('404');
        }
        $employee = Employee::find($id);
        if($employee->company_id == Auth::user()->company_id){
            $employee->delete();
            //$user = User::where('employee_id',$id)->delete();
            return redirect('employee')->with('message','Employee Deleted Successfully!');
        }else{
            return redirect('employee')->with('message','Do not try to be too smart!');
        }
    }

    public function update($page, $employee_id, Request $request){
        if(roles() != "" && !in_array(24, json_decode(roles(),false))){
            return redirect('404');
        }
        $employee               = Employee::where('id',$employee_id)->first();
        $employment_info        = EmploymentInfo::where('employee_id',$employee_id)->first();
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
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

        if($employment_info == "") { $info_id = ""; } else { $info_id = $employment_info->id; }
        return view('employee.update.update',compact('page','employee_id','departments','designations','info_id','currencies',
        'banks','earning_components','deduction_components','employee','employment_info','earnings','deductions','payroll_info','bank_branches'));
    }

    public function update_personal_info($employee_id,Request $request){
        $find_employee = Employee::where('company_id',Auth::user()->company_id)->where('id','!=',$employee_id)->where('employee_id',$request->employee_id)->first();
        if($find_employee != "") {
            return redirect('employee/update/personal/'.$employee_id)->with('error_message', 'This Employee ID is already Used!');
        }

        /*$email = User::where('employee_id',null)->where('email',$request->email_address)->first();
        if($email != "") {
            return redirect('employee/update/personal/'.$employee_id)->with('error_message', 'This Email is already Used!');
        }

        $email_validation = User::where('employee_id','!=',$employee_id)->where('email',$request->email_address)->first();
        if($email_validation != "") {
            return redirect('employee/update/personal/'.$employee_id)->with('error_message', 'This Email is already Used!');
        }*/

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
        
        if($request->hasFile('employee_cv'))
        {
            $cv = json_decode($employee->employee_cv);
            foreach($request->file('employee_cv') as $file)
            {
                $filesize = filesize($file);
                $filesize_in_kb = $filesize / 1024;
                if($filesize_in_kb <= 2048) {
                    $custom_name    = md5(uniqid(rand(), true)).$employee->company_id.'.'.$file->getClientOriginalExtension();
                    $file->move('storage/employees/', $custom_name);
                    array_push($cv, $custom_name);
                }
            }
            $employee->employee_cv = json_encode($cv);
        }

        $employee->save();

        if($request->employee_id =='') {
            $employee->employee_id          = 1000 + $employee->id;
            $employee->save();
        }

        if($request->email_address !="") {
            /*$user = User::where('employee_id',$employee->id)->first();
            $user->email = $request->email_address;
            $user->save();*/
        }

        return redirect('employee/update/employment/'.$employee->id)->with('message', 'Personal Information Updated Successfully!');
    }

    public function update_employment_info(Request $request, $info_id = ""){
        if($request->employee_id != "") {
            if($request->current_status == "Active") {
                $employee_limit = Company::where('id',Auth::user()->company_id)->first()->employee_limit;
                $count_active_employee = Employee::join('employment_infos','employees.id','employment_infos.employee_id')->where('company_id',Auth::user()->company_id)->where('current_status','Active')->count();
                if($count_active_employee >= $employee_limit) {
                    return redirect('employee')->with('error_message', 'Employee limit Exceed!');
                }
            }
            
            if($info_id == ""){
                $employee = new EmploymentInfo;
            }else{
                $employee = EmploymentInfo::where('id',$info_id)->first();
            }

            $employee->employee_id              = $request->employee_id;
            $employee->department_id            = $request->department_id;
            $employee->designation_id           = $request->designation_id;
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

    public function update_payroll_info(Request $request, $employee_id = ""){
        if($request->employee_id != "") {
            $preDataCount = EmployeeEarningDeduction::where('employee_id',$employee_id)->count();
            if($preDataCount != 0 && $preDataCount != "") {
                EmployeeEarningDeduction::where('employee_id',$employee_id)->delete();
            }


            $earnings_row_count = count($request->salary_component_id);
            if($request->salary_component_id !=[null]) {
                for($i = 0; $i < $earnings_row_count; $i++) {
                    if($request->salary_component_id[$i] != "") {
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
                }
            }
            
            $deductions_row_count = count($request->ded_salary_component_id);
            if($request->ded_salary_component_id !=[null]) {
                for($i = 0; $i < $deductions_row_count; $i++) {
                    if($request->ded_salary_component_id[$i] != "") {
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
                }
            }

            $count_payroll_info = PayrollInfo::where('employee_id',$employee_id)->count();
            if($count_payroll_info == 0){
                $info = new PayrollInfo;
            }else{
                $info = PayrollInfo::where('employee_id',$employee_id)->first();
            }
            $info->employee_id                          = $request->employee_id;
            $info->festival_bonus_per_festival          = $request->festival_bonus_per_festival;
            $info->gratuity_amount                      = $request->gratuity_amount;
            $info->gratuity_opening_balance             = $request->gratuity_opening_balance;
            $info->company_pf_opening_balance           = $request->company_pf_opening_balance;
            $info->employee_pf_opening_balance          = $request->employee_pf_opening_balance;
            $info->investment_amount                    = $request->investment_amount;
            $info->ot_allowed                           = $request->ot_allowed;
            $info->hourly_ot_rate                       = $request->hourly_ot_rate;
            $info->currency_id                          = $request->currency_id;
            $info->save();
            return redirect('employee')->with('message', 'Employee Updated Successfully!');
        }
    }


    public function cv_delete($employee_id,$name) {
        $employee = Employee::where('id',$employee_id)->first();
        if($name != "") {
            Storage::delete('employees/'.$name);
            $index = array_search($name, json_decode($employee->employee_cv));
            
            $cv = [];
            foreach(json_decode($employee->employee_cv) as $file)
            {
                if($file != $name) {
                    array_push($cv, $file);
                }
            }

            $employee->employee_cv = json_encode($cv);
            $employee->save();
        }
        return back()->with('message', 'CV Deleted Successfully!');
    }

    public function search_employee($department_id) {
        $employees   = EmploymentInfo::orderBy('employment_infos.id','asc')
                    ->join('employees','employees.id','employment_infos.employee_id')
                    ->where('employees.company_id',Auth::user()->company_id);
        if($department_id != "" && $department_id != 0){
            $employees    = $employees->where('department_id',$department_id);
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

    public function search_employee_increment_id($department_id) {

        //$earnings    = EmployeeEarningDeduction::where('earning_or_deduction','earnings')->get();
        $employees   = EmploymentInfo::orderBy('employment_infos.id','asc')
                    ->join('employees','employees.id','employment_infos.employee_id')
                    ->where('employees.company_id',Auth::user()->company_id);
                    
        if($department_id != "" && $department_id != 0){
            $employees    = $employees->where('department_id',$department_id);
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


    public function search_employee_with_designation($department_id,$designation_id="") {
        $employees   = EmploymentInfo::orderBy('employment_infos.id','asc')
                    ->join('employees','employees.id','employment_infos.employee_id')
                    ->where('employees.company_id',Auth::user()->company_id);
        if($department_id != "" && $department_id != 0){
            $employees    = $employees->where('department_id',$department_id);
        }

        if($designation_id != "" && $designation_id != 0){
            $employees   = $employees->where('designation_id',$designation_id);
        }

        $employees = $employees->get();

        if(count($employees) > 0) {
            foreach($employees as $employee) {
                echo "<option value=".$employee->employee_id.">".$employee->employee_id.' - '.$employee->name .' - '.employee_designation($employee->id)."</option>";
            }
        }else {
            echo "";
        }
    }

    public function search_employee_increment_id_with_designation($department_id,$designation_id="") {

        //$earnings    = EmployeeEarningDeduction::where('earning_or_deduction','earnings')->get();
        $employees   = EmploymentInfo::orderBy('employment_infos.id','asc')
                    ->join('employees','employees.id','employment_infos.employee_id')
                    ->where('employees.company_id',Auth::user()->company_id);
                    
        if($department_id != "" && $department_id != 0){
            $employees    = $employees->where('department_id',$department_id);
        }

        if($designation_id != "" && $designation_id != 0){
            $employees   = $employees->where('designation_id',$designation_id);
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


    public function tax_calculation() {
        $employee_id = 2;
        $date = date('Y-m-d',strtotime('02-06-2021'));

        $tax_rule           = TaxRule::where('company_id',Auth::user()->company_id)->where('query_income_date_from','<=',$date)->where('query_income_date_to','>=',$date)->first();
        $tax_with_festival  = monthly_income_tax_calculation_with_festival_bonus($employee_id,$date);
        //list($income_tax,$yearly_festival_bonus,$yearly_basic_salary,$yearly_house_rent,$yearly_house_rent_non_tax_limit,$yearly_conveyance,$yearly_conveyance_non_tax_limit,$yearly_medical,$yearly_medical_non_tax_limit,$yearly_company_pf,$yearly_other_allowance) = explode("_",$tax_with_festival);

        //$tax_without_festival   = monthly_income_tax_calculation($employee_id,$date);

        $employee_info   = Employee::where('id',$employee_id)->first();
        $employment_info = EmploymentInfo::where('employee_id',$employee_id)->first();

        return view('configurations.tax_rule_setup.tax_with_festival',compact('employee_info','employment_info','tax_rule','tax_with_festival'));
        //return "Tax With Festival Bonus: <b>".$tax_with_festival."</b><br>  Tax Without Festial Bonus: <b>".$tax_without_festival."</b>";
        //return $tax_without_festival;*/
        //return $tax_with_festival;
    }

    public function tax_calculation_without_festival() {
        $employee_id = 2;
        $date = date('Y-m-d',strtotime('02-06-2021'));

        $tax_rule           = TaxRule::where('company_id',Auth::user()->company_id)->where('query_income_date_from','<=',$date)->where('query_income_date_to','>=',$date)->first();
        $tax_with_festival  = monthly_income_tax_calculation($employee_id,$date);
        //list($income_tax,$yearly_festival_bonus,$yearly_basic_salary,$yearly_house_rent,$yearly_house_rent_non_tax_limit,$yearly_conveyance,$yearly_conveyance_non_tax_limit,$yearly_medical,$yearly_medical_non_tax_limit,$yearly_company_pf,$yearly_other_allowance) = explode("_",$tax_with_festival);

        //$tax_without_festival   = monthly_income_tax_calculation($employee_id,$date);

        $employee_info   = Employee::where('id',$employee_id)->first();
        $employment_info = EmploymentInfo::where('employee_id',$employee_id)->first();

        return view('configurations.tax_rule_setup.tax_without_festival',compact('employee_info','employment_info','tax_rule','tax_with_festival'));
        //return "Tax With Festival Bonus: <b>".$tax_with_festival."</b><br>  Tax Without Festial Bonus: <b>".$tax_without_festival."</b>";
        //return $tax_without_festival;*/
        //return $tax_with_festival;
    }
}