<?php
namespace Ragnaroq\Controller;

use Ragnaroq\App\Config;
use Ragnaroq\App\Page\HtmlPage;
use Ragnaroq\Base\BaseController;
use OAuth2\Client;

/**
 * Class HomeController
 * @package Ragnaroq\Controller
 */
class OAuth2Controller extends BaseController
{
    public function authorizeCallback()
    {
        // If there is an error parameter, show that error
        $error = $this->request->get('error');
        if (!empty($error)) {
            HtmlPage::renderError5xx(500, "<pre>OAuth Error: "
                . $this->request->get('error') . "\n"
                . '<a href="/authorize_callback">Retry</a></pre>');
            return;
        }

        // Get OAuth2 settings
        $authorizeUrl = Config::get('oauth.authorization_url');
        $clientId = Config::get('oauth.client');
        $clientSecret = Config::get('oauth.secret');
        $redirectUrl = Config::get('oauth.redirect_uri');
        $userAgent = Config::get('oauth.user_agent');

        // Prepare OAuth2 client to request an authorization code
        $client = new Client($clientId, $clientSecret, Client::AUTH_TYPE_AUTHORIZATION_BASIC);
        $client->setCurlOption(CURLOPT_USERAGENT, $userAgent);

        // Request an authorization code if there isn't one in the GET
        // parameter code, if there is one, request an access token
        $code = $this->request->get('code');
        if (empty($code))
        {
            $this->session->delete('accessToken');
            $authUrl = $client->getAuthenticationUrl($authorizeUrl, $redirectUrl, array(
                'scope' => 'identity',
                'state' => 'As64xA3ueT6sjxiazAA7278yhs6103jx',
                'duration' => 'permanent'
            ));
            header('Location: ' . $authUrl);
            return;
        }
        else
        {
            $this->session->requestOAuth2AccessToken($code);
            header('Location: /');
            return;
        }
    }
}
