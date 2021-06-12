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
use App\PaySlipReceiver;
use App\PayrollBank;
use App\ProvidentFund;
use App\DepositSalaryTax;
use App\IncomeTax;
use App\GeneralSetting;
use App\RosterEmployee;
use App\GeneralLeave;
use App\EarningDeductionAdjustment;
use App\DepositSalaryTaxDetail;
use App\TaxRule;

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

function shift_name_from_roster($employee_id,$date) {
    $roster = RosterEmployee::where('employee_id',$employee_id)->where('date',$date)->first();
    if($roster != "") {
        $shift = ShiftType::where('id',$roster->shift_id)->first();
        if($shift != "") {
            return $shift->shift_short_name;
        }else{
            return "";
        }
    }else{
        return "";
    }
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

function get_employment_info($employee_id) {
    $employee = EmploymentInfo::where('employee_id',$employee_id)->first();
    if($employee != "") {
        return $employee;
    }else{
        return "";
    }
}

function employee_department($employee_id) {
    $info = EmploymentInfo::where('employee_id',$employee_id)->first();
    if($info != "") {
        $department = Department::where('id',$info->department_id)->first();
        if($department != "") {
            return $department->name;
        }else{
            return "";
        }
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
        $setting = GeneralSetting::where('company_id',Auth::user()->company_id)->first();
        if($setting->amount_in_word == "Crore-Lakh-Thousand" || $setting->amount_in_word == "Crore-Lac-Thousand") {
            $intpart = floor( $amount );
            $fraction = $amount - $intpart;

            $num = $intpart;
            $explrestunits = "" ;
            if(strlen($num)>3) {
                $lastthree = substr($num, strlen($num)-3, strlen($num));
                $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
                $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);
                for($i=0; $i<sizeof($expunit); $i++) {
                    // creates each of the 2's group and adds a comma to the end
                    if($i==0) {
                        $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                    } else {
                        $explrestunits .= $expunit[$i].",";
                    }
                }
                $thecash = $explrestunits.$lastthree;
            } else {
                $thecash = $num;
            }

            if($fraction != 0) {
                $fraction = substr(number_format($fraction,2), -2);
                $full_digit = $thecash.'.'.$fraction;
            }else {
                $full_digit = $thecash;
            }

        }else if($setting->amount_in_word == "Billion-Million-Thousand") {
            $intpart = floor( $amount );
            $fraction = $amount - $intpart;

            if($fraction >= 0.5) {
                $amount = $amount - 1;
            }

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

function get_company_info($company_id) {
    return Company::where('id',$company_id)->first();
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

function mail_pay_slip_total($month,$year) {
   return PaySlipReceiver::where('month',$month)->where('year',$year)->count();
}

function mail_pay_slip_sent($month,$year) {
    return PaySlipReceiver::where('month',$month)->where('year',$year)->where('status',1)->count();
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
    /*$deposit_tax    = DepositSalaryTax::where('id',$tax_id)->first();
    $from           = date('Y-m-01',strtotime($deposit_tax->from));
    $to             = date('Y-m-31',strtotime($deposit_tax->to));*/
    $total_amount   = 0;

    /*$employees      = EmploymentInfo::orderBy('id','asc');

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
    }*/

    $total_tax      = DepositSalaryTaxDetail::where('tax_id',$tax_id);

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
        40                  => 'Forty',
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
        if($decimalValue != "" && $decimalValue != 0) {
            $string .= " And ".$currency_sub_unit.' '.decimal_in_word($decimalValue);
        }
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

function all_portion_amount($employee_id,$month,$year) {
    $company_pf =  ProvidentFund::where('company_id',Auth::user()->company_id)
                        ->where('employee_id',$employee_id)->where('status',0)
                        ->where('month',$month)->where('year',$year)
                        ->where('type','Company Portion')->first();

    if($company_pf != ""){
        $company_pf_amount = $company_pf->amount;
    }else{
        $company_pf_amount = 0;
    }

    $employee_pf =  ProvidentFund::where('company_id',Auth::user()->company_id)
                        ->where('employee_id',$employee_id)->where('status',0)
                        ->where('month',$month)->where('year',$year)
                        ->where('type','Employee Portion')->first();

    if($employee_pf != ""){
        $employee_pf_amount = $employee_pf->amount;
    }else{
        $employee_pf_amount = 0;
    }

    return $company_pf_amount."_".$employee_pf_amount;
}

function hourly_ot_rate($employee_id) {
    $payroll_info = PayrollInfo::where('employee_id',$employee_id)->first();
    if($payroll_info != "") {
        $hourly_ot_rate = $payroll_info->hourly_ot_rate;
    }else{
        $hourly_ot_rate = 0;
    }
    return $hourly_ot_rate;
}

function calculate_attendance_days($employee_id,$from_date,$to_date) {
    $ok_days        = 0;
    $leave_days     = 0;
    $late_days      = 0;
    $absent_days    = 0;
    $day_off_days   = 0;
    $govt_holidays  = 0;

    $attendances    = Attendance::where('employee_id',$employee_id)->whereBetween('date',[$from_date,$to_date])->get();

    foreach($attendances as $attendance) {

        //OK
        if($attendance->readable_status == 'OK') {
            $ok_days = $ok_days + 1;
        }

        //Late
        if($attendance->readable_status == 'Late') {
            $late_days = $late_days + 1;
        }

        //GOVT Holiday
        if($attendance->readable_status == 'Govt Holiday') {
            $govt_holidays = $govt_holidays + 1;
        }

        //Leave
        if($attendance->readable_status == 'Leave') {
            $leave_days = $leave_days + 1;
        }

        //Absent
        if($attendance->readable_status == 'Absent') {
            $absent_days = $absent_days + 1;
        }

        //Days Off
        if($attendance->readable_status == 'Day Off') {
            $day_off_days = $day_off_days + 1;
        }
    }

    return $ok_days."_".$leave_days."_".$late_days."_".$absent_days."_".$day_off_days."_".$govt_holidays;
}

function gross_salary($employee_id) {
    $payroll_infos = EmployeeEarningDeduction::where('employee_id',$employee_id)->where('earning_or_deduction','earnings')->get();
    $gross_salary = 0;
    foreach($payroll_infos as $payroll_info) {
        $get_component_id = $payroll_info->salary_component_id;

        $component_detail = SalaryComponent::where('id',$get_component_id)->first();

        if($component_detail->component_reference != "PF Company Portion" && $component_detail->component_reference != "Festival Bonus" && $component_detail->component_reference != "Gratuity") {
            $gross_salary   = $gross_salary + $payroll_info->final_amount;
        }
    }
    return $gross_salary;
}

function get_user_name($user_id) {
    $user = User::where('id',$user_id)->first();
    if($user != "") {
        return $user->name;
    }else{
        return "";
    }
}

function leave_days($employee_id,$leave_type_id,$from_date,$to_date) {
    $leave_requests = LeaveRequest::where('employee_id',$employee_id)->where('leave_type_id',$leave_type_id)->whereBetween('start_date', [$from_date, $to_date])->whereBetween('end_date', [$from_date, $to_date])->where('status','Approved')->get();
    if(count($leave_requests) != 0) {
        $leave_days = 0;
        foreach($leave_requests as $leave) {
            $leave_days = $leave_days + $leave->leave_days;
        }
        return $leave_days;
    }else{
        return "0";
    }
}

function get_leave_info_id($employee_id,$leave_type_id) {
    $leave_info     = LeaveInfo::where('employee_id',$employee_id)->where('leave_type_id',$leave_type_id)->first();
    if($leave_info != "") {
        return $leave_info->id;
    }else{
        return "";
    }
}

function get_earning_component_amount($employee_id,$salary_component_id,$date) {
    $month  = date('F',strtotime($date));
    $year   = date('Y',strtotime($date));

    $adjustment = EarningDeductionAdjustment::where('employee_id',$employee_id)->where('salary_component_id',$salary_component_id)->where('earning_or_deduction','earnings')->where('month',$month)->where('year',$year)->where('status',1)->first();
    if($adjustment != "") {
        if($adjustment->type == 'Increase') {
            return $adjustment->amount;
        }elseif($adjustment->type == 'Decrease') {
            return '-'.$adjustment->amount;
        }
    }else{
        return "0";
    }
}

function get_deduction_component_amount($employee_id,$salary_component_id,$date) {
    $month  = date('F',strtotime($date));
    $year   = date('Y',strtotime($date));

    $adjustment = EarningDeductionAdjustment::where('employee_id',$employee_id)->where('salary_component_id',$salary_component_id)->where('earning_or_deduction','deductions')->where('month',$month)->where('year',$year)->where('status',1)->first();
    if($adjustment != "") {
        if($adjustment->type == 'Increase') {
            return $adjustment->amount;
        }elseif($adjustment->type == 'Decrease') {
            return '-'.$adjustment->amount;
        }
    }else{
        return "0";
    }
}

function company_portion($month,$year,$employee_id) {
    $company_pf = ProvidentFund::where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->where('type','Company Portion')->first();
    if($company_pf != "") {
        return $company_pf->amount;
    }else {
        return 0;
    }
}

function own_portion($month,$year,$employee_id) {
    $own_pf = ProvidentFund::where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->where('type','Employee Portion')->first();
    if($own_pf != "") {
        return $own_pf->amount;
    }else {
        return 0;
    }
}

function previous_own_portion($date,$employee_id) {
    $own_portion = 0;
    $payroll_info = PayrollInfo::where('employee_id',$employee_id)->first();
    if($payroll_info != "") {
        if($payroll_info->employee_pf_opening_balance != "") {
            $own_portion = $own_portion + $payroll_info->employee_pf_opening_balance;
        }
    }
    $own_pfs = ProvidentFund::where('employee_id',$employee_id)->where('query_date','<',$date)->where('type','Employee Portion')->get();
    if(count($own_pfs) != 0) {
        foreach($own_pfs as $pf) {
            $own_portion = $own_portion + $pf->amount;
        }
    }

    return $own_portion;
}

function previous_company_portion($date,$employee_id) {
    $own_portion = 0;
    $payroll_info = PayrollInfo::where('employee_id',$employee_id)->first();
    if($payroll_info != "") {
        if($payroll_info->company_pf_opening_balance != "") {
            $own_portion = $own_portion + $payroll_info->company_pf_opening_balance;
        }
    }
    $own_pfs = ProvidentFund::where('employee_id',$employee_id)->where('query_date','<',$date)->where('type','Company Portion')->get();
    if(count($own_pfs) != 0) {
        foreach($own_pfs as $pf) {
            $own_portion = $own_portion + $pf->amount;
        }
    }

    return $own_portion;
}

function present_own_portion($from_date,$to_date,$employee_id) {
    $own_portion = 0;
    $own_pfs = ProvidentFund::where('employee_id',$employee_id)->whereBetween('query_date',[$from_date,$to_date])->where('type','Employee Portion')->get();
    if(count($own_pfs) != 0) {
        foreach($own_pfs as $pf) {
            $own_portion = $own_portion + $pf->amount;
        }
    }

    return $own_portion;
}

function present_company_portion($from_date,$to_date,$employee_id) {
    $own_portion = 0;
    $own_pfs = ProvidentFund::where('employee_id',$employee_id)->whereBetween('query_date',[$from_date,$to_date])->where('type','Company Portion')->get();
    if(count($own_pfs) != 0) {
        foreach($own_pfs as $pf) {
            $own_portion = $own_portion + $pf->amount;
        }
    }

    return $own_portion;
}

function total_component_amount($from_date,$to_date,$employee_id,$component_id) {
    $total_component_amount = 0;
    $salary_details = SalarySheetDetails::where('employee_id',$employee_id)->where('component_id',$component_id)->whereBetween('query_date',[$from_date,$to_date])->get();
    foreach($salary_details as $detail) {
        $total_component_amount = $total_component_amount + $detail->payable_amount;
    }

    return $total_component_amount;
}

function total_deposit_tax_amount($tax_id) {
    $total_tax = 0;
    $tax_details = DepositSalaryTaxDetail::where('tax_id',$tax_id)->get();
    foreach($tax_details as $detail) {
        $total_tax = $total_tax + $detail->amount;
    }
    return $total_tax;
}

function datepicker_format() {
    $general_settings = GeneralSetting::where('company_id',Auth::user()->company_id)->first();
    if($general_settings != "") {
        return $general_settings->date_format;
    }else{
        return "";
    }
}

function get_biometric_redirect_url($company_id) {
    return Company::where('id',$company_id)->first()->biometric_machine_redirect_url;
}

function employee_current_status($employee_id) {
    $employment_info = EmploymentInfo::where('employee_id',$employee_id)->first();
    if($employment_info != "") {
        return $employment_info->current_status; 
    }else{
        return "";
    }
}

function monthly_income_tax_calculation($employee_id,$date) {
    $income_date = date('Y-m-d',strtotime($date));
    $tax_rule           = TaxRule::where('company_id',Auth::user()->company_id)->where('query_income_date_from','<=',$income_date)->where('query_income_date_to','>=',$income_date)->first();
    $employee_info      = Employee::where('id',$employee_id)->first();
    $employee_earnings  = EmployeeEarningDeduction::where('employee_id',$employee_id)->where('earning_or_deduction','earnings')->get();
    $taxable_income     = 0;
    $tax_amount         = 0;
    $investment_amount  = 0;
    $investment_allow_amount = 0;

    if($tax_rule != "") {
        foreach($employee_earnings as $earning) {
            $salary_component_detail = SalaryComponent::where('id',$earning->salary_component_id)->first();
            if($salary_component_detail != "") {
                $component_name     = $salary_component_detail->component_reference;
                $component_amount   = $earning->final_amount;
    
                if($component_name == "Basic Salary") {
                    $basic_salary   = $component_amount;
                    $taxable_income = $taxable_income + $component_amount;
                }
    
                elseif($component_name == "House Rent") {
                    $house_rent_allowance_amount_monthly    = $tax_rule->house_rent_allowance_amount_monthly;
                    $house_rent_allowance_in_percent        = ($basic_salary * $tax_rule->house_rent_allowance_in_percent) / 100;
    
                    if($house_rent_allowance_amount_monthly <= $house_rent_allowance_in_percent) {
                        if($house_rent_allowance_amount_monthly <= $component_amount) {
                            $taxable_income     = $taxable_income + ($component_amount - $house_rent_allowance_amount_monthly);
                        }
                    }else{
                        if($house_rent_allowance_in_percent <= $component_amount) {
                            $taxable_income     = $taxable_income + ($component_amount - $house_rent_allowance_in_percent);
                        }
                    }
                }
    
                elseif($component_name == "Convenience") {
                    $conveyance_allowance_amount_monthly = $tax_rule->conveyance_allowance_amount_monthly;
                    if($conveyance_allowance_amount_monthly < $component_amount) {
                        $taxable_income     = $taxable_income + ($component_amount - $conveyance_allowance_amount_monthly);
                    }
                }
    
                elseif($component_name == "Medical") {
                    $medical_allowance_amount_monthly   = $tax_rule->medical_allowance_amount_monthly;
                    $medical_allowance_in_percent       = ($basic_salary * $tax_rule->medical_allowance_in_percent)/100;
    
                    if($medical_allowance_amount_monthly <= $medical_allowance_in_percent) {
                        if($medical_allowance_amount_monthly <= $component_amount) {
                            $taxable_income     = $taxable_income + ($component_amount - $medical_allowance_amount_monthly);
                        }
                    }else{
                        if($medical_allowance_in_percent <= $component_amount) {
                            $taxable_income     = $taxable_income + ($component_amount - $medical_allowance_in_percent);
                        }
                    }
                }
    
                elseif($component_name == "PF Company Portion") {
                    $taxable_income     = $taxable_income + $component_amount;
                }

                elseif($component_name == "Gratuity") {
                    $taxable_income     = $taxable_income + 0;
                }

                else{
                    $taxable_income     = $taxable_income + $component_amount;
                }
            }
        }

        if($employee_info->gender == "Female") {
            $female_or_65_above_male = 1;
        }else{
            $age = Carbon::parse($employee_info->date_of_birth)->diff($tax_rule->query_income_date_to)->format('%y');
            if($age > 65) {
                $female_or_65_above_male = 1;
            }else{
                $female_or_65_above_male = 0;
            }
        }

        if($female_or_65_above_male == 1) {
            if($tax_rule->first_amount_female_above_65_aged_male_monthly <= $taxable_income) {
                $remaining_taxable_amount = $taxable_income - $tax_rule->first_amount_female_above_65_aged_male_monthly;

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->second_amount_female_above_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->second_amount_female_above_65_aged_male_monthly * $tax_rule->second_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->second_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->second_amount_female_above_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->third_amount_female_above_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->third_amount_female_above_65_aged_male_monthly * $tax_rule->third_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->third_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->third_amount_female_above_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->forth_amount_female_above_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->forth_amount_female_above_65_aged_male_monthly * $tax_rule->forth_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->forth_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->forth_amount_female_above_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->fifth_amount_female_above_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->fifth_amount_female_above_65_aged_male_monthly * $tax_rule->fifth_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->fifth_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->fifth_amount_female_above_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->rest_tax_rate_percent) / 100);
                }

            }
        }else{
            if($tax_rule->first_amount_below_65_aged_male_monthly <= $taxable_income) {
                $remaining_taxable_amount = $taxable_income - $tax_rule->first_amount_below_65_aged_male_monthly;

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->second_amount_below_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->second_amount_below_65_aged_male_monthly * $tax_rule->second_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->second_tax_rate_percent) / 100);
                    }
                    
                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->second_amount_below_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->third_amount_below_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->third_amount_below_65_aged_male_monthly * $tax_rule->third_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->third_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->third_amount_below_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->forth_amount_below_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->forth_amount_below_65_aged_male_monthly * $tax_rule->forth_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->forth_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->forth_amount_below_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->fifth_amount_below_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->fifth_amount_below_65_aged_male_monthly * $tax_rule->fifth_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->fifth_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->fifth_amount_below_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->rest_tax_rate_percent) / 100);
                }
            }
        }
    
        //return $taxable_income;

        $percent_25_of_taxable_income = ($taxable_income * 25) / 100;

        $employee_earnings_deductions  = EmployeeEarningDeduction::where('employee_id',$employee_id)->get();
        foreach($employee_earnings_deductions as $earning_deduction) {
            $component_detail = SalaryComponent::where('id',$earning_deduction->salary_component_id)->first();
            if($component_detail != "") {
                $earning_deduction_component_name   = $component_detail->component_reference;
                $earning_deduction_component_amount = $earning_deduction->final_amount;
            }

            if($earning_deduction_component_name == "PF Company Portion") {
                $investment_amount     = $investment_amount + $earning_deduction_component_amount;
            }

            if($earning_deduction_component_name == "PF Employee Portion") {
                $investment_amount     = $investment_amount + $earning_deduction_component_amount;
            }
        }

        $employee_payroll_info = PayrollInfo::where('employee_id',$employee_id)->first();
        if($employee_payroll_info != "") {
            $investment_amount = $investment_amount + $employee_payroll_info->investment_amount;
        }

        if(0 < $investment_amount && $investment_amount <= $tax_rule->maximum_investment_amount_allowed_monthly) {
            if($taxable_income <= $tax_rule->investment_amount_less_amount_monthly) {
                $investment_allow_amount = $investment_allow_amount + ($percent_25_of_taxable_income * $tax_rule->investment_amount_less_percent) / 100;
            }
            elseif($taxable_income > $tax_rule->investment_amount_more_amount_monthly) {
                $investment_allow_amount = $investment_allow_amount + ($percent_25_of_taxable_income * $tax_rule->investment_amount_more_percent) / 100;
            }
        }

        return $income_tax = $tax_amount - $investment_allow_amount;

    }else{
        return "Null";
    }


}

function monthly_income_tax_calculation_with_festival_bonus($employee_id,$date) {
    $income_date = date('Y-m-d',strtotime($date));
    $tax_rule           = TaxRule::where('company_id',Auth::user()->company_id)->where('query_income_date_from','<=',$income_date)->where('query_income_date_to','>=',$income_date)->first();
    $payroll_info       = PayrollInfo::where('employee_id',$employee_id)->first();
    $employee_info      = Employee::where('id',$employee_id)->first();
    $employee_earnings  = EmployeeEarningDeduction::where('employee_id',$employee_id)->where('earning_or_deduction','earnings')->get();
    $taxable_income     = 0;
    $tax_amount         = 0;
    $investment_amount  = 0;
    $investment_allow_amount = 0;

    if($payroll_info != "") {
        $taxable_income = $taxable_income + $payroll_info->festival_bonus_per_festival;
    }

    if($tax_rule != "") {
        foreach($employee_earnings as $earning) {
            $salary_component_detail = SalaryComponent::where('id',$earning->salary_component_id)->first();
            if($salary_component_detail != "") {
                $component_name     = $salary_component_detail->component_reference;
                $component_amount   = $earning->final_amount;
    
                if($component_name == "Basic Salary") {
                    $basic_salary   = $component_amount;
                    $taxable_income = $taxable_income + $component_amount;
                }
    
                elseif($component_name == "House Rent") {
                    $house_rent_allowance_amount_monthly    = $tax_rule->house_rent_allowance_amount_monthly;
                    $house_rent_allowance_in_percent        = ($basic_salary * $tax_rule->house_rent_allowance_in_percent) / 100;
    
                    if($house_rent_allowance_amount_monthly <= $house_rent_allowance_in_percent) {
                        if($house_rent_allowance_amount_monthly <= $component_amount) {
                            $taxable_income     = $taxable_income + ($component_amount - $house_rent_allowance_amount_monthly);
                        }
                    }else{
                        if($house_rent_allowance_in_percent <= $component_amount) {
                            $taxable_income     = $taxable_income + ($component_amount - $house_rent_allowance_in_percent);
                        }
                    }
                }
    
                elseif($component_name == "Convenience") {
                    $conveyance_allowance_amount_monthly = $tax_rule->conveyance_allowance_amount_monthly;
                    if($conveyance_allowance_amount_monthly < $component_amount) {
                        $taxable_income     = $taxable_income + ($component_amount - $conveyance_allowance_amount_monthly);
                    }
                }
    
                elseif($component_name == "Medical") {
                    $medical_allowance_amount_monthly   = $tax_rule->medical_allowance_amount_monthly;
                    $medical_allowance_in_percent       = ($basic_salary * $tax_rule->medical_allowance_in_percent)/100;
    
                    if($medical_allowance_amount_monthly <= $medical_allowance_in_percent) {
                        if($medical_allowance_amount_monthly <= $component_amount) {
                            $taxable_income     = $taxable_income + ($component_amount - $medical_allowance_amount_monthly);
                        }
                    }else{
                        if($medical_allowance_in_percent <= $component_amount) {
                            $taxable_income     = $taxable_income + ($component_amount - $medical_allowance_in_percent);
                        }
                    }
                }
    
                elseif($component_name == "PF Company Portion") {
                    $taxable_income     = $taxable_income + $component_amount;
                }

                elseif($component_name == "Gratuity") {
                    $taxable_income     = $taxable_income + 0;
                }

                else{
                    $taxable_income     = $taxable_income + $component_amount;
                }
            }
        }

        if($employee_info->gender == "Female") {
            $female_or_65_above_male = 1;
        }else{
            $age = Carbon::parse($employee_info->date_of_birth)->diff($tax_rule->query_income_date_to)->format('%y');
            if($age > 65) {
                $female_or_65_above_male = 1;
            }else{
                $female_or_65_above_male = 0;
            }
        }

        if($female_or_65_above_male == 1) {
            if($tax_rule->first_amount_female_above_65_aged_male_monthly <= $taxable_income) {
                $remaining_taxable_amount = $taxable_income - $tax_rule->first_amount_female_above_65_aged_male_monthly;

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->second_amount_female_above_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->second_amount_female_above_65_aged_male_monthly * $tax_rule->second_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->second_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->second_amount_female_above_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->third_amount_female_above_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->third_amount_female_above_65_aged_male_monthly * $tax_rule->third_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->third_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->third_amount_female_above_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->forth_amount_female_above_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->forth_amount_female_above_65_aged_male_monthly * $tax_rule->forth_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->forth_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->forth_amount_female_above_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->fifth_amount_female_above_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->fifth_amount_female_above_65_aged_male_monthly * $tax_rule->fifth_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->fifth_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->fifth_amount_female_above_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->rest_tax_rate_percent) / 100);
                }

            }
        }else{
            if($tax_rule->first_amount_below_65_aged_male_monthly <= $taxable_income) {
                $remaining_taxable_amount = $taxable_income - $tax_rule->first_amount_below_65_aged_male_monthly;

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->second_amount_below_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->second_amount_below_65_aged_male_monthly * $tax_rule->second_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->second_tax_rate_percent) / 100);
                    }
                    
                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->second_amount_below_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->third_amount_below_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->third_amount_below_65_aged_male_monthly * $tax_rule->third_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->third_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->third_amount_below_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->forth_amount_below_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->forth_amount_below_65_aged_male_monthly * $tax_rule->forth_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->forth_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->forth_amount_below_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    if($remaining_taxable_amount >= $tax_rule->fifth_amount_below_65_aged_male_monthly) {
                        $tax_amount = $tax_amount + (($tax_rule->fifth_amount_below_65_aged_male_monthly * $tax_rule->fifth_tax_rate_percent) / 100);
                    }else{
                        $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->fifth_tax_rate_percent) / 100);
                    }

                    $remaining_taxable_amount = $remaining_taxable_amount - $tax_rule->fifth_amount_below_65_aged_male_monthly;
                }

                if($remaining_taxable_amount > 0) {
                    $tax_amount = $tax_amount + (($remaining_taxable_amount * $tax_rule->rest_tax_rate_percent) / 100);
                }
            }
        }
    
        //return $taxable_income;

        $percent_25_of_taxable_income = ($taxable_income * 25) / 100;

        $employee_earnings_deductions  = EmployeeEarningDeduction::where('employee_id',$employee_id)->get();
        foreach($employee_earnings_deductions as $earning_deduction) {
            $component_detail = SalaryComponent::where('id',$earning_deduction->salary_component_id)->first();
            if($component_detail != "") {
                $earning_deduction_component_name   = $component_detail->component_reference;
                $earning_deduction_component_amount = $earning_deduction->final_amount;
            }

            if($earning_deduction_component_name == "PF Company Portion") {
                $investment_amount     = $investment_amount + $earning_deduction_component_amount;
            }

            if($earning_deduction_component_name == "PF Employee Portion") {
                $investment_amount     = $investment_amount + $earning_deduction_component_amount;
            }
        }

        $employee_payroll_info = PayrollInfo::where('employee_id',$employee_id)->first();
        if($employee_payroll_info != "") {
            $investment_amount = $investment_amount + $employee_payroll_info->investment_amount;
        }

        if(0 < $investment_amount && $investment_amount <= $tax_rule->maximum_investment_amount_allowed_monthly) {
            if($taxable_income <= $tax_rule->investment_amount_less_amount_monthly) {
                $investment_allow_amount = $investment_allow_amount + ($percent_25_of_taxable_income * $tax_rule->investment_amount_less_percent) / 100;
            }
            elseif($taxable_income > $tax_rule->investment_amount_more_amount_monthly) {
                $investment_allow_amount = $investment_allow_amount + ($percent_25_of_taxable_income * $tax_rule->investment_amount_more_percent) / 100;
            }
        }

        return $income_tax = $tax_amount - $investment_allow_amount;

    }else{
        return "Null";
    }


}
