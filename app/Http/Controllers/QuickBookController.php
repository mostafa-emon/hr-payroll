<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;
use Redirect;

class QuickBookController extends Controller
{
    public function firstCall() {
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => 'ABh75wOJ7wm73xm67Ay7usGdKsIv1AhTVnMKldtBhoB8vKH3oJ',
            'ClientSecret' => 'nAkjbOfAf7DIV1Mi1hsHDVikU8RjUmEtcUUr1duh',
            'RedirectURI' => 'http://localhost:8001/qb-auth-success',
            'scope' =>'com.intuit.quickbooks.accounting',
            'baseUrl' => "development"
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
            'auth_mode' => 'oauth2',
            'ClientID' => 'ABh75wOJ7wm73xm67Ay7usGdKsIv1AhTVnMKldtBhoB8vKH3oJ',
            'ClientSecret' => 'nAkjbOfAf7DIV1Mi1hsHDVikU8RjUmEtcUUr1duh',
            'RedirectURI' => 'http://localhost:8001/qb-auth-success',
            'scope' =>'com.intuit.quickbooks.accounting',
            'baseUrl' => "development"
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $parseUrl = $this->parseAuthRedirectUrl($_SERVER['QUERY_STRING']);

        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);
        $dataService->updateOAuth2Token($accessToken);
        
        echo $accessToken->getAccessToken();
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
