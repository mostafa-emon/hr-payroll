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
use App\ProvidentFund;
use App\DepositSalaryTax;
use App\IncomeTax;
use App\GeneralSetting;

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

function get_employee_id($employee_id) {
    return Employee::where('id',$employee_id)->value('employee_id');
}

function bank_account_no($employee_id){
    return EmploymentInfo::where('employee_id',$employee_id)->value('bank_account_no');
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

function employee_provident_fund($month,$year,$employee_id) {
    $company_pf = ProvidentFund::where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->where('type','Company Portion')->where('status',0)->first();
    if($company_pf != "") {
        return $company_pf->amount;
    }else {
        return 0;
    }
}

function get_provident_fund_total($month,$year,$employee_ids) {
    $data = ProvidentFund::where('month',$month)->where('year',$year)->whereIn('employee_id',$employee_ids)->sum('amount');
    if($data == "" || $data == 0) {
        return 0;
    }else {
        return $data;
    }
}

function total_tax($tax_id) {
    $deposit_tax    = DepositSalaryTax::where('id',$tax_id)->first();
    $from           = date('Y-m-01',strtotime($deposit_tax->from));
    $to             = date('Y-m-31',strtotime($deposit_tax->to));
    $total_amount   = 0;

    $employees      = EmploymentInfo::orderBy('id','asc');

    if($deposit_tax->department_id != "") {
        $employees  = $employees->where('department_id',$deposit_tax->department_id);
    }

    if($deposit_tax->project_id !="") {
        $employees  = $employees->where('project_id',$deposit_tax->project_id);
    }

    if($deposit_tax->branch_id !="") {
        $employees  = $employees->where('branch_id',$deposit_tax->branch_id);
    }

    $employees      = $employees->get();

    $employee_ids   = array();

    foreach($employees as $employee) {
        $employee_ids[] = $employee->employee_id;
    }

    $total_tax      = IncomeTax::where('company_id',Auth::user()->company_id)->whereIn('employee_id',$employee_ids)
                    ->whereBetween('query_date', [$from, $to]);

    if($deposit_tax->currency_id !="") {
        $total_tax  = $total_tax->where('currency_id',$deposit_tax->currency_id);
    }

    $count_total_tax = $total_tax->count();
    $income_taxes  = $total_tax->get();

    foreach($income_taxes as $income_tax) {
        $total_amount = $total_amount + $income_tax->amount;
    }
    return $count_total_tax."_".$total_amount;
}

function amount_in_word($amount,$employee_id = "") {
    $setting        = GeneralSetting::where('company_id',Auth::user()->company_id)->first();

    if($employee_id != "") {
        $currency_id    = PayrollInfo::where('employee_id',$employee_id)->first()->currency_id;
        $currency       = Currency::where('id',$currency_id)->first();
        $currency_unit      = $currency->full_unit_name;
        $currency_sub_unit  = $currency->sub_unit_name;
    }else {
        $currency_unit      = "";
        $currency_sub_unit  = "";
    }
    

    if($setting->amount_in_word == "Crore-Lac-Thousand" || $setting->amount_in_word == "Crore-Lakh-Thousand") {
        $number = $amount;
        $no = round($number);
        $decimal = round($number - ($no = floor($number)), 2) * 100;    
        $digits_length = strlen($no);    
        $i = 0;
        $str = array();
        $words = array(
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety');
        
        if($setting->amount_in_word == "Crore-Lac-Thousand") {
            $digits = array('', 'Hundred', 'Thousand', 'Lac', 'Crore');
        }else {
            $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        }
        
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
            } else {
                $str [] = null;
            }  
        }
        
        $Rupees = implode(' ', array_reverse($str));
        $paise = ($decimal) ? "And ".$currency_sub_unit." " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
        return ($Rupees ? $currency_unit .' '. $Rupees : '') . $paise . " Only";
    }
    
    else {
        return $currency_unit." ".convert_number_to_words($amount,$amount,$currency_sub_unit).' Only';
    }
}

function decimal_in_word($amount) {
    $number = $amount;
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    
    $digits = array('', 'Hundred', 'Thousand', 'Lac', 'Crore');
    
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
    return ($Rupees ? $currency_unit .' '. $Rupees : '') . $paise;
}

function convert_number_to_words($number,$amount="",$currency_sub_unit = "") {
    $hyphen      = ' ';
    $conjunction = ' ';
    $separator   = ' ';
    $negative    = 'negative ';
    $decimal     = ' and ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (is_float($amount)) {
        $intValue = intval($amount);
        $decimalValue = $amount - $intValue;
        $string .= " And ".$currency_sub_unit.' '.decimal_in_word($decimalValue);
    }

    return $string;
}

function get_default_currency_employee() {
    $default_currency = Currency::where('default',1)->where('company_id',Auth::user()->company_id)->first();
    return PayrollInfo::where('currency_id',$default_currency->id)->first()->employee_id;
}

function get_selected_currency_employee($currency_id) {
    return PayrollInfo::where('currency_id',$currency_id)->first()->employee_id;
}