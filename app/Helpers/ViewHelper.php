<?php

use Illuminate\Support\Facades\Auth;
use App\Role;
use QuickBooksOnline\API\DataService\DataService;
use App\QuickBook;
use Carbon\Carbon;
use App\Company;
use App\Voucher;

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
                    ->count();
        }else if($api_type == "Check"){
            $count = Voucher::where('type','Cash-Payment-Voucher')
                    ->where('api_type','cheque')
                    ->where('document_id',$id)
                    ->count();
        }else if($api_type == "Pay Bills"){
            $count = Voucher::where('type','Cash-Payment-Voucher')
                    ->where('api_type','bill_payment')
                    ->where('document_id',$id)
                    ->count();
        }
    }
    return $count;
}
