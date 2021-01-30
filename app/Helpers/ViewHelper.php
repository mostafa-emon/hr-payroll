<?php

use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\DataService\DataService;
use App\Role;
use App\User;
use App\ShiftType;
use App\Employee;
use App\EmploymentInfo;
use App\Department;
use App\Designation;
use App\Project;
use App\Branch;
use App\QuickBook;
use Carbon\Carbon;
use App\Company;
use App\Voucher;
use App\Setting;
use App\ChequeTransaction;
use App\MoneyReceipt;
use App\LeaveType;
use App\LeaveInfo;
use App\LeaveRequest;
use App\LeaveBalance;
use App\CampaignReceiver;
use App\SalaryComponent;
use App\EmployeeEarningDeduction;
use App\Attendance;
use App\GovtHolidayDetail;
use App\PayrollInfo;
use App\SalarySheet;
use App\SalarySheetDetails;
use App\Currency;
use App\MailPaySlip;
use App\PayrollBank;

function leftmenu_color() {
    return User::where('id',Auth::user()->id)->value('leftmenu_color');
}

function leave_type_name($leave_id){
    return LeaveType::where('id',$leave_id)->value('leave_name');
}

function employee_name($employee_id){
    return Employee::where('employee_id',$employee_id)->value('name');
}

function department_name($department_id){
    return Department::where('id',$department_id)->value('name');
}

function employee_name_by_increment_id($employee_id) {
    return Employee::where('id',$employee_id)->value('name');
}

function shift_name($shift_id) {
    return ShiftType::where('id',$shift_id)->value('name');
}

function designation_name($designation_id){
    return Designation::where('id',$designation_id)->value('name');
}

function project_name($project_id){
    return Project::where('id',$project_id)->value('name');
}

function branch_name($branch_id){
    return Branch::where('id',$branch_id)->value('name');
}

function currency_name($currency_id){
    return Currency::where('id',$currency_id)->value('currency_name');
}

function bank_name($bank_id){
    return PayrollBank::where('id',$bank_id)->value('bank_name');
}

function leave_balance_left($leave_info_id,$employee_id,$applicable_for){
    $leave_info     = LeaveInfo::where('id',$leave_info_id)->first();
    $employee       = Employee::where('id',$employee_id)->first();

    $curYear = $applicable_for;
    $from = $curYear.'-01-01';
    $to = $curYear.'-12-31';

    $leave_requests = LeaveRequest::where('employee_id',$employee->id)->whereBetween('start_date', [$from, $to])->whereBetween('end_date', [$from, $to])->where('leave_type_id',$leave_info->leave_type_id)->where('status','!=','Rejected')->get();

    if($leave_requests !=""){
        $before_leave = 0;
        foreach($leave_requests as $leave_request) {
            $before_leave = $before_leave + $leave_request->leave_days;
        }
    }

    if($leave_info !=""){
        $allotment_year = date('Y', strtotime($leave_info->opening_balance_date));
        if($allotment_year == $curYear){

            if($leave_requests != "") {
                $remaining_leave = $leave_info->opening_balance - $before_leave;
                return $remaining_leave;
            }

        }else{

            $leave_balances = LeaveBalance::where('employee_id',$employee->id)->where('leave_type_id',$leave_info->leave_type_id)->where('applicable_year',$curYear)->get();
            if($leave_balances !=""){
                $balance = 0;
                foreach($leave_balances as $leave_balance){
                    $balance = $balance + $leave_balance->transfer_amount;
                }
            }

            if(count($leave_balances) == 0){

                if($leave_requests != "") {
                    $remaining_leave = $leave_info->yearly_allotment - $before_leave;
                    return $remaining_leave;
                }

            }else{
                if($leave_requests != "") {
                    $total_leave     = $leave_info->yearly_allotment + $balance;
                    $remaining_leave = $total_leave - $before_leave;
                    return $remaining_leave;
                }
            }
        }
    }



}

function get_employee_info($employee_id) {
    $employee = Employee::where('id',$employee_id)->first();
    if($employee != "") {
        return $employee;
    }else{
        return "";
    }
}

function employee_department($employee_id) {
    $info = EmploymentInfo::where('employee_id',$employee_id)->first();
    if($info != "") {
        return Department::where('id',$info->department_id)->first()->name;
    }else{
        return "";
    }
}

function employee_designation($employee_id) {
    $info = EmploymentInfo::where('employee_id',$employee_id)->first();
    if($info != "") {
        return Designation::where('id',$info->designation_id)->first()->name;
    }else{
        return "";
    }
}

function document_upload_facility($company_id) {
    return Company::where('id',$company_id)->first()->document_upload;
}

function roles(){
    $user_roles = Role::where('id',Auth::user()->roles)->first();
    if($user_roles == null){$roles = "";} else {$roles = $user_roles->access;}
    return $roles;
}

function getToken(){
    $auth_details = QuickBook::where('company_id',Auth::user()->company_id)->first();
    if($auth_details->token_validity < Carbon::now()){
        if($auth_details->refresh_token_validity < Carbon::now()){
            return redirect('/qb-auth');
        }else{
            $company    = Company::where('id',Auth::user()->company_id)->first();
            $OAuth      = QuickBook::where('company_id',$company->id)->first();

            $dataService = DataService::Configure(array(
                'auth_mode'         => 'oauth2',
                'ClientID'          => $company->qb_client_id,
                'ClientSecret'      => $company->qb_client_secret,
                'RedirectURI'       => config('app.qb_auth_redirect_url'),
                'baseUrl'           => $company->qb_environment,
                'refreshTokenKey'   => $OAuth->refresh_token,
                'QBORealmID'        => $company->qb_company_id,
            ));
            
            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();

            $quick_book = QuickBook::where('company_id',$company->id)->first();
            $quick_book->token          = $refreshedAccessTokenObj->getAccessToken();
            $quick_book->token_validity = $refreshedAccessTokenObj->getAccessTokenExpiresAt();
            $quick_book->save();

            return $quick_book->token;
        }
    }else{
        return $auth_details->token;
    }
}

function number_formatting($amount){
    if($amount != ""){
        $setting = Setting::where('company_id',Auth::user()->company_id)->first();
        if($setting->amount_in_word_format == "crore_lakh_thousand" || $setting->amount_in_word_format == "crore_lac_thousand") {
            $intpart = floor( $amount );
            $fraction = $amount - $intpart;

            $lenght = strlen($intpart);
            if($lenght > 3) {
                $last_3_digits  = substr($intpart, -3);
                $rest_digits    = substr($intpart, 0, -3);

                $rest_digits = (string)$rest_digits;
                $arr = str_split($rest_digits, "2");
                $comma_separated = implode(",", $arr);

                $full_digit = $comma_separated.','.$last_3_digits;

                if($fraction != 0) {
                    $fraction = substr(number_format($fraction,2), -2);
                    $full_digit = $full_digit.'.'.$fraction;
                }else{
                    $full_digit = $full_digit.'.00';
                }
            }else{
                $full_digit = "&nbsp;".number_format($amount,2);
            }
            
        }else if($setting->amount_in_word_format == "billion_million_thousand") {
            $intpart = floor( $amount );
            $fraction = $amount - $intpart;
            
            $lenght = strlen($intpart);
            if($lenght > 3) {
                $full_digit = number_format($amount, 0, '', ',');

                if($fraction != 0) {
                    $fraction = substr(number_format($fraction,2), -2);
                    $full_digit = $full_digit.'.'.$fraction;
                }else{
                    $full_digit = $full_digit.'.00';
                }
            }else{
                $full_digit = "&nbsp;".number_format($amount,2);
            }
        }

        return $full_digit;
    }else {
        return "";
    }
}  

function get_auto_increment_employee_id($employee_id) {
    return Employee::where('employee_id',$employee_id)->first()->id;
}

function get_company_name($company_id) {
    return Company::where('id',$company_id)->value('name');
}

function campaign_total_receiver_and_sent($campaign_id) {
    $total_number = CampaignReceiver::where('campaign_id',$campaign_id);
    if($total_number != ""){
        $total_receiver = $total_number->count();
        $total_sent     = $total_number->where('status',1)->count();
        return $total_receiver."_".$total_sent;
    }
}

function get_pf_amount($employee_id) {
    $salary_component = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_reference','PF Company Portion')->first();
    $employee = Employee::where('employee_id',$employee_id)->first();
    if($employee != "") {
        $payroll_info = EmployeeEarningDeduction::where('employee_id',$employee->id)->where('salary_component_id',$salary_component->id)->first();
        if($payroll_info != ''){
            if($payroll_info->final_amount != '') {
                return $payroll_info->final_amount;
            }else{
                return "";
            }
        }else{
            return "";
        }
    }else{
        return "";
    }
}

function total_absent_days($employee_id,$request_month,$request_year) {
    $month = date('m', strtotime($request_month));
    $cur_month = $request_year.'-'.$month;
    $first_day_of_month = $cur_month.'-01';
    $last_day_of_month  = $cur_month.'-31';
    //$total_days         = date('t', strtotime($cur_month));

    $count_total_absent_days = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->whereBetween('date', [$first_day_of_month, $last_day_of_month])->where('status','ABSENT')->count();
    return $count_total_absent_days;
}

function per_day_salary($employee_id,$request_month,$request_year) {
    $month = date('m', strtotime($request_month));
    $cur_month = $request_year.'-'.$month;
    $total_days         = date('t', strtotime($cur_month));
    
    $total_salary       = 0;
    $payroll_infos      = EmployeeEarningDeduction::where('employee_id',$employee_id)->where('earning_or_deduction','earnings')->get();

    foreach($payroll_infos as $payroll_info) {
        $get_component_id = $payroll_info->salary_component_id;

        $component_detail = SalaryComponent::where('id',$get_component_id)->first();
        
        if($component_detail->component_reference != "PF Company Portion") {
            $total_salary   = $total_salary + $payroll_info->final_amount;
        }

    }

    $per_day_salary     = $total_salary / $total_days;

    return $per_day_salary;
}

function find_holiday($date) {
    $holiday = GovtHolidayDetail::where('company_id',Auth::user()->company_id)->where('date',$date)->first();
    if($holiday != "") {
        return $holiday;
    }else{
        return "";
    }
}

function get_gratuity_amount($employee_id) {
    $employee = Employee::where('employee_id',$employee_id)->first();
    if($employee != "") {
        $payroll_info = PayrollInfo::where('employee_id',$employee->id)->first();
        if($payroll_info != ''){
            if($payroll_info->gratuity_amount != '') {
                return $payroll_info->gratuity_amount;
            }else{
                return "";
            }
        }else{
            return "";
        }
    }else{
        return "";
    }
}

function total_employee($month,$year) {
    return SalarySheet::where('year',$year)->where('month',$month)->count();
}

function get_component_name($component_id) {
    $component = SalaryComponent::where('id',$component_id)->first();
    if($component != "") {
        return $component->component_name;
    }else{
        return "";
    }
}

function get_salary_component_amount($month,$year,$employee_id,$component_id) {
    $data = SalarySheetDetails::where('month',$month)->where('year',$year)->where('employee_id',$employee_id)->where('component_id',$component_id)->first();
    if($data != "") {
        return $amount = $data->payable_amount;
    }else{
        return "";
    }
}

function get_salary_sheet_component_total($month,$year,$component_id,$employee_ids) {
    $data = SalarySheetDetails::where('month',$month)->where('year',$year)->where('component_id',$component_id)->whereIn('employee_id',$employee_ids)->sum('payable_amount');
    if($data == "" || $data == 0) {
        return 0;
    }else {
        return $data;
    }
}

function count_mail_pay_slip($month,$year) {
    return MailPaySlip::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->count();
}