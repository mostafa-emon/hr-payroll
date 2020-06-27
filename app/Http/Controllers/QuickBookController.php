<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;
use Redirect;
use App\QuickBook;
use Auth;
use App\Company;

class QuickBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function firstCall() {
        $company = Company::where('id',Auth::user()->company_id)->first();

        $dataService = DataService::Configure(array(
            'auth_mode'     => 'oauth2',
            'ClientID'      => $company->qb_client_id,
            'ClientSecret'  => $company->qb_client_secret,
            'RedirectURI'   => config('app.qb_auth_redirect_url'),
            'scope'         =>'com.intuit.quickbooks.accounting',
            'baseUrl'       => $company->qb_environment,
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

        if (isset($accessToken)) {
            $accessToken = $accessToken;
            $accessTokenJson = array('token_type' => 'bearer',
                'access_token' => $accessToken->getAccessToken(),
                'refresh_token' => $accessToken->getRefreshToken(),
                'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
                'expires_in' => $accessToken->getAccessTokenExpiresAt()
            );
            $dataService->updateOAuth2Token($accessToken);
            $oauthLoginHelper = $dataService -> getOAuth2LoginHelper();
            $CompanyInfo = $dataService->getCompanyInfo();
        }

        return Redirect::to($authUrl);
    }

    public function processCode()
    {
        $company = Company::where('id',Auth::user()->company_id)->first();

        $dataService = DataService::Configure(array(
            'auth_mode'     => 'oauth2',
            'ClientID'      => $company->qb_client_id,
            'ClientSecret'  => $company->qb_client_secret,
            'RedirectURI'   => config('app.qb_auth_redirect_url'),
            'scope'         =>'com.intuit.quickbooks.accounting',
            'baseUrl'       => $company->qb_environment,
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $parseUrl = $this->parseAuthRedirectUrl($_SERVER['QUERY_STRING']);

        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);
        $dataService->updateOAuth2Token($accessToken);
        
        $count = QuickBook::where('company_id',Auth::user()->company_id)->count();

        if($count == 0) {
            $quick_book = new QuickBook();
            $quick_book->company_id = Auth::user()->company_id;
            $quick_book->token = $accessToken->getAccessToken();
            $quick_book->refresh_token = $accessToken->getRefreshToken();
            $quick_book->token_validity = $accessToken->getAccessTokenExpiresAt();
            $quick_book->refresh_token_validity = $accessToken->getRefreshTokenExpiresAt();
            $quick_book->save();
        }else{
            $quick_book = QuickBook::where('company_id',Auth::user()->company_id)->first();
            $quick_book->company_id = Auth::user()->company_id;
            $quick_book->token = $accessToken->getAccessToken();
            $quick_book->refresh_token = $accessToken->getRefreshToken();
            $quick_book->token_validity = $accessToken->getAccessTokenExpiresAt();
            $quick_book->refresh_token_validity = $accessToken->getRefreshTokenExpiresAt();
            $quick_book->save();
        }
        
        return redirect('/');
    }

    public function parseAuthRedirectUrl($url)
    {
        parse_str($url,$qsArray);
        return array(
            'code' => $qsArray['code'],
            'realmId' => $qsArray['realmId']
        );
    }

    public function refreshToken(){
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
        $quick_book->refresh_token  = $refreshedAccessTokenObj->getRefreshToken();
        $quick_book->refresh_token_validity = $refreshedAccessTokenObj->getRefreshTokenExpiresAt();
        $quick_book->save();

        return redirect('/');
    }
}
