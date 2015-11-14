<?php
namespace Ragnaroq\Controller;

use OAuth2\Client;
use Ragnaroq\App\Config;
use Ragnaroq\Base\BaseController;

/**
 * This is the standard controller of this micro-framework,
 * you can use it to render the homepage of the app.
 *
 * Class HomeController
 * @package Ragnaroq\Controller
 */
class HomeController extends BaseController
{
    /**
     * Here you can render the homepage of the app
     */
    public function index()
    {
        // Get OAuth2 parameters from config and session
        $clientId = Config::get('oauth.client');
        $clientSecret = Config::get('oauth.secret');
        $userAgent = Config::get('oauth.user_agent');
        $accessTokenResult = $this->session->read('accessToken');

        // Setup OAuth2 client to request resources from Reddit
        $client = new Client($clientId, $clientSecret, Client::AUTH_TYPE_AUTHORIZATION_BASIC);
        $client->setCurlOption(CURLOPT_USERAGENT, $userAgent);
        $client->setAccessToken($accessTokenResult["access_token"]);
        $client->setAccessTokenType(Client::ACCESS_TOKEN_BEARER);

        // Request user response
        $response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");
        $this->view->render("Home", array('me' => $response['result']));
    }

    public function beforeAction()
    {
        // If there isn't an access token in the Session start a new OAuth2 flow
        $accessTokenResult = $this->session->read('accessToken');
        if (empty($accessTokenResult)) {
            $this->session->store('returnUrl', $this->request->getUri());
            header('Location: /authorize_callback');
            exit;
        }
    }
}
