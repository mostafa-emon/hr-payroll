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
    private $company;

    public function __construct()
    {
        $this->middleware('auth');
        $this->company = Company::where('id',Auth::user()->company_id)->first();
    }
    
    public function firstCall() {
        return response()->json(Auth::user()->company_id);
        $dataService = DataService::Configure(array(
            'auth_mode'     => 'oauth2',
            'ClientID'      => 'ABh75wOJ7wm73xm67Ay7usGdKsIv1AhTVnMKldtBhoB8vKH3oJ',
            'ClientSecret'  => 'nAkjbOfAf7DIV1Mi1hsHDVikU8RjUmEtcUUr1duh',
            'RedirectURI'   => 'http://localhost:8001/qb-auth-success',
            'scope'         =>'com.intuit.quickbooks.accounting',
            'baseUrl'       => "development"
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
        $dataService = DataService::Configure(array(
            'auth_mode'     => 'oauth2',
            'ClientID'      => 'ABh75wOJ7wm73xm67Ay7usGdKsIv1AhTVnMKldtBhoB8vKH3oJ',
            'ClientSecret'  => 'nAkjbOfAf7DIV1Mi1hsHDVikU8RjUmEtcUUr1duh',
            'RedirectURI'   => 'http://localhost:8001/qb-auth-success',
            'scope'         =>'com.intuit.quickbooks.accounting',
            'baseUrl'       => "development"
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
        
    } 
}
