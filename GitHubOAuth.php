<?php

class GitHubOAuth
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $access_token;
    private $api_base_url = 'https://api.github.com';

    public function __construct($client_id, $client_secret, $redirect_uri)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }

    public function getAuthorizationUrl()
    {
        $params = array(
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'scope' => 'user',
        );

        $query = http_build_query($params);
        return 'https://github.com/login/oauth/authorize?' . $query;
    }

    public function getAccessToken($auth_code)
    {
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $auth_code,
            'redirect_uri' => $this->redirect_uri,
        );

        $url = 'https://github.com/login/oauth/access_token';

        $options = array(
            'http' => array(
                'header' => "Accept: application/json\r\n",
                'method' => 'POST',
                'content' => http_build_query($params),
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            $data = json_decode($response, true);
            if (isset($data['access_token'])) {
                $this->access_token = $data['access_token'];
                return $this->access_token;
            }
        }

        return false;
    }

    public function refreshAccessToken($refresh_token)
    {
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $refresh_token,
        );

        $url = 'https://github.com/login/oauth/access_token';

        $options = array(
            'http' => array(
                'header' => "Accept: application/json\r\n",
                'method' => 'POST',
                'content' => http_build_query($params),
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            $data = json_decode($response, true);
            if (isset($data['access_token'])) {
                $this->access_token = $data['access_token'];
                return $this->access_token;
            }
        }

        return false;
    }

    public function revokeAccessToken($access_token)
    {
        $url = 'https://api.github.com/applications/' . $this->client_id . '/tokens/' . $access_token;

        $options = array(
            'http' => array(
                'header' => "Authorization: token {$this->client_secret}\r\n",
                'method' => 'DELETE',
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            return true;
        }

        return false;
    }

    public function getUserData($access_token)
    {
        $url = $this->api_base_url . '/user';

        $options = array(
            'http' => array(
                'header' => "Authorization: token $access_token\r\n",
                'method' => 'GET',
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            $data = json_decode($response, true);
            return $data;
        }

        return false;
    }

    public function getRateLimit()
    {
        $url = $this->api_base_url . '/rate_limit';

        $response = file_get_contents($url);

        if ($response !== false) {
            $data = json_decode($response, true);
            return $data['rate'];
        }

        return false;
    }
}

?>
