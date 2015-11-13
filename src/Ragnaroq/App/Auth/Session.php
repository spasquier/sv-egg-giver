<?php
namespace Ragnaroq\App\Auth;

use OAuth2\Client;
use Ragnaroq\App\Config;
use Symfony\Component\HttpFoundation\Request;

class Session
{
    private $req;
    private $storage;

    /**
     * Session constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->req = $request;
        $this->storage = $request->getSession();
    }

    /**
     * Reads a value stored int the session by its unique key
     *
     * @param $valueKey string Unique key that identifies the stored value
     * @param $defaultValue string Default value if there isn't a value with the given key
     * @return mixed
     */
    public function read($valueKey, $defaultValue = null)
    {
        return $this->storage->get($valueKey, $defaultValue);
    }

    /**
     * Stores a value in the session identifying it with a unique key
     *
     * @param $valueKey string Unique key to identify the stored value
     * @param $value mixed Value to be saved in the Session
     */
    public function store($valueKey, $value)
    {
        $this->storage->set($valueKey, $value);
    }

    /**
     * Removes a value stored in the session that has the given key
     *
     * @param $valueKey string Unique key that identifies the value to be removed
     */
    public function delete($valueKey)
    {
        $this->storage->remove($valueKey);
    }

    /**
     * Requests an OAuth2 access token and saves it in the Session
     * as an array representing the response and with key "accessToken".
     *
     * @param $code
     * @throws \OAuth2\Exception
     */
    public function requestOAuth2AccessToken($code)
    {
        // Get OAuth2 settings
        $accessTokenUrl = Config::get('oauth.access_token_url');
        $clientId = Config::get('oauth.client');
        $clientSecret = Config::get('oauth.secret');
        $redirectUrl = Config::get('oauth.redirect_uri');
        $userAgent = Config::get('oauth.user_agent');

        // Prepare OAuth2 client
        $client = new Client($clientId, $clientSecret, Client::AUTH_TYPE_AUTHORIZATION_BASIC);
        $client->setCurlOption(CURLOPT_USERAGENT, $userAgent);

        // Get access token
        $accessTokenResult = $this->read('accessToken');
        if (null == $accessTokenResult) {
            $params = array('code' => $code, "redirect_uri" => $redirectUrl);
            $response = $client->getAccessToken($accessTokenUrl, "authorization_code", $params);
            $accessTokenResult = $response["result"];
            $this->store('accessToken', $accessTokenResult);
        }

        // How to request any resource from Reddit
        // $client->setAccessToken($accessTokenResult["access_token"]);
        // $client->setAccessTokenType(Client::ACCESS_TOKEN_BEARER);
        // $this->model->response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");
    }
}
