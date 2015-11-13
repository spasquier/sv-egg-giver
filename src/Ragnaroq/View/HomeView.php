<?php
namespace Ragnaroq\View;

use Ragnaroq\Base\BaseView;

/**
 * Here you must simply pass data from your model to your view template,
 * but just if you want, the template can be just static HTML.
 *
 * Class ExampleView
 * @package Ragnaroq\View
 */
class HomeView extends BaseView
{
    public function defineTemplate()
    {
        $this->setTemplate("Home");
    }

    public function output()
    {
        $error = $this->request->get('error');
        if (!empty($error))
        {
            echo("<pre>OAuth Error: " . $this->request->get('error')."\n");
            echo('<a href="/">Retry</a></pre>');
            die;
        }

        $authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
        $accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
        $clientId = 'sv-egg-giver';
        $clientSecret = 'awywHxOLxvEOAmQVKSJmuAS3C5Q';
        $userAgent = 'SVEggGiverApp/0.1 by ragnaroq';

        $redirectUrl = "https://svapp.triparticion.xyz/authorize_callback";
        
        $client = new \OAuth2\Client($clientId, $clientSecret, \OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
        $client->setCurlOption(CURLOPT_USERAGENT,$userAgent);

        $code = $this->request->get('code');
        if (empty($code))
        {
            $authUrl = $client->getAuthenticationUrl($authorizeUrl, $redirectUrl,
                array("scope" => "identity", "state" => "As64xA3ueT6sjxiazAA7278yhs6103jx"));
            header("Location: ".$authUrl);
            die("Redirecting...");
        }
        else
        {
            $params = array("code" => $this->request->get('code'), "redirect_uri" => $redirectUrl);
            $response = $client->getAccessToken($accessTokenUrl, "authorization_code", $params);

            $accessTokenResult = $response["result"];
            $client->setAccessToken($accessTokenResult["access_token"]);
            $client->setAccessTokenType(\OAuth2\Client::ACCESS_TOKEN_BEARER);

            $response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");

            echo('<strong>Response for fetch me.json:</strong><pre>');
            print_r($response);
            echo('</pre>');
        }
        
        //require $this->getTemplate();
    }
}
