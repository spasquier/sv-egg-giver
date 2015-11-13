<?php
namespace Ragnaroq\Controller;

use Ragnaroq\Base\BaseController;
use OAuth2\Client;
use Ragnaroq\Model\OAuth2Model;

/**
 * Class HomeController
 * @package Ragnaroq\Controller
 */
class OAuth2Controller extends BaseController
{
    public function authorizeCallback()
    {
        $error = $this->request->get('error');
        if (!empty($error)) {
            echo("<pre>OAuth Error: " . $this->request->get('error')."\n");
            echo('<a href="/">Retry</a></pre>');
            die;
        }

        $authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
        $accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
        $clientId = 'xSDj20h3AKfhxw';
        $clientSecret = 'awywHxOLxvEOAmQVKSJmuAS3C5Q';
        $userAgent = 'SVEggGiverApp/0.1 by ragnaroq';

        $redirectUrl = "http://svapp.triparticion.xyz/authorize_callback";

        $client = new Client($clientId, $clientSecret, Client::AUTH_TYPE_AUTHORIZATION_BASIC);
        $client->setCurlOption(CURLOPT_USERAGENT,$userAgent);

        $code = $this->request->get('code');
        if (empty($code) && !isset($_SESSION['accessTokenResult']))
        {
            $authUrl = $client->getAuthenticationUrl($authorizeUrl, $redirectUrl,
                array("scope" => "identity", "state" => "As64xA3ueT6sjxiazAA7278yhs6103jx"));
            header("Location: ".$authUrl);
            die("Redirecting...");
        }
        else
        {
            if (isset($_SESSION['accessTokenResult'])) {
                $params = array("code" => $this->request->get('code'), "redirect_uri" => $redirectUrl);
                $response = $client->getAccessToken($accessTokenUrl, "authorization_code", $params);
                $accessTokenResult = $response["result"];
            } else {
                $accessTokenResult = $_SESSION['accessTokenResult'];
            }

            $client->setAccessToken($accessTokenResult["access_token"]);
            $client->setAccessTokenType(Client::ACCESS_TOKEN_BEARER);

            /** @var OAuth2Model $model */
            $model = $this->model;
            $model->response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");
        }
    }
}
