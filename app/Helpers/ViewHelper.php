<?php

use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\DataService\DataService;
use App\Role;
use App\User;
use App\QuickBook;
use Carbon\Carbon;
use App\Company;
use App\Voucher;
use App\Setting;
use App\ChequeTransaction;
use App\MoneyReceipt;

function leftmenu_color() {
    return User::where('id',Auth::user()->id)->value('leftmenu_color');
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

function is_voucher_printed($voucher_type,$api_type,$id){
    $count = 0;
    if($voucher_type == "Cash-Payment-Voucher"){
        if($api_type == "Expense"){
            $count = Voucher::where('type','Cash-Payment-Voucher')
                    ->where('api_type','expense')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Check"){
            $count = Voucher::where('type','Cash-Payment-Voucher')
                    ->where('api_type','cheque')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Pay Bills"){
            $count = Voucher::where('type','Cash-Payment-Voucher')
                    ->where('api_type','bill_payment')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }
    }

    if($voucher_type == "Bank-Payment-Voucher"){
        if($api_type == "Expense"){
            $count = Voucher::where('type','Bank-Payment-Voucher')
                    ->where('api_type','expense')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Check"){
            $count = Voucher::where('type','Bank-Payment-Voucher')
                    ->where('api_type','cheque')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Pay Bills"){
            $count = Voucher::where('type','Bank-Payment-Voucher')
                    ->where('api_type','bill_payment')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }
    }

    if($voucher_type == "Cheque-Printing"){
        if($api_type == "Expense"){
            $count = ChequeTransaction::where('api_type','expense')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Check"){
            $count = ChequeTransaction::where('api_type','cheque')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Pay Bills"){
            $count = ChequeTransaction::where('api_type','bill_payment')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }
    }

    if($voucher_type == "Contra-Voucher"){
        $count = Voucher::where('type','Contra-Voucher')
                ->where('document_id',$id)
                ->where('status',1)
                ->count();
    }

    if($voucher_type == "Journal-Voucher"){
        $count = Voucher::where('type','Journal-Voucher')
                ->where('document_id',$id)
                ->where('status',1)
                ->count();
    }

    if($voucher_type == "Cash-Receipt-Voucher"){
        if($api_type == "Bank Deposit"){
            $count = Voucher::where('type','Cash-Receipt-Voucher')
                    ->where('api_type','bank_deposit')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Receive Payment"){
            $count = Voucher::where('type','Cash-Receipt-Voucher')
                    ->where('api_type','receive_payment')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Sales Receipt"){
            $count = Voucher::where('type','Cash-Receipt-Voucher')
                    ->where('api_type','sales_receipt')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }
    }

    if($voucher_type == "Bank-Receipt-Voucher"){
        if($api_type == "Bank Deposit"){
            $count = Voucher::where('type','Bank-Receipt-Voucher')
                    ->where('api_type','bank_deposit')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Receive Payment"){
            $count = Voucher::where('type','Bank-Receipt-Voucher')
                    ->where('api_type','receive_payment')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Sales Receipt"){
            $count = Voucher::where('type','Bank-Receipt-Voucher')
                    ->where('api_type','sales_receipt')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }
    }

    if($voucher_type == "Money-Receipt"){
        if($api_type == "Bank Deposit"){
            $count = MoneyReceipt::where('api_type','bank_deposit')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Receive Payment"){
            $count = MoneyReceipt::where('api_type','receive_payment')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }else if($api_type == "Sales Receipt"){
            $count = MoneyReceipt::where('api_type','sales_receipt')
                    ->where('document_id',$id)
                    ->where('status',1)
                    ->count();
        }
    }
    return $count;
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
