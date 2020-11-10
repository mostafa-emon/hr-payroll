<?php

use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\DataService\DataService;
use App\Role;
use App\User;
use App\Employee;
use App\EmploymentInfo;
use App\Department;
use App\Designation;
use App\QuickBook;
use Carbon\Carbon;
use App\Company;
use App\Voucher;
use App\Setting;
use App\ChequeTransaction;
use App\MoneyReceipt;
use App\LeaveType;

function leftmenu_color() {
    return User::where('id',Auth::user()->id)->value('leftmenu_color');
}

function leave_type_name($leave_id){
    return LeaveType::where('id',$leave_id)->value('leave_name');
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
