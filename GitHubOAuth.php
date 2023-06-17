<?php

class GitHubOAuth
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $state;

    public function __construct($client_id, $client_secret, $redirect_uri)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->state = bin2hex(random_bytes(16));
        $_SESSION['oauth_state'] = $this->state;
    }

    public function getAuthorizationUrl($scope = 'user')
    {
        $authorization_url = 'https://github.com/login/oauth/authorize';
        $auth_params = array(
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'state' => $this->state,
            'scope' => $scope
        );

        return $authorization_url . '?' . http_build_query($auth_params);
    }

    public function getAccessToken($auth_code)
    {
        $token_url = 'https://github.com/login/oauth/access_token';

        $token_params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $auth_code,
            'redirect_uri' => $this->redirect_uri,
            'state' => $this->state
        );

        $token_headers = array(
            'Accept: application/json',
            'User-Agent: YourApp'
        );

        $token_options = array(
            'http' => array(
                'method' => 'POST',
                'header' => implode("\r\n", $token_headers),
                'content' => http_build_query($token_params),
                'ignore_errors' => true
            )
        );

        $token_context = stream_context_create($token_options);
        $token_response = file_get_contents($token_url, false, $token_context);

        if ($token_response === false) {
            return false;
        }

        $token_data = json_decode($token_response, true);

        if (isset($token_data['access_token'])) {
            return $token_data['access_token'];
        }

        return false;
    }

    public function getUserData($access_token)
    {
        $user_url = 'https://api.github.com/user';
        $user_headers = array(
            'Authorization: Bearer ' . $access_token,
            'User-Agent: YourApp'
        );

        $user_options = array(
            'http' => array(
                'method' => 'GET',
                'header' => implode("\r\n", $user_headers),
                'ignore_errors' => true
            )
        );

        $user_context = stream_context_create($user_options);
        $user_response = file_get_contents($user_url, false, $user_context);

        if ($user_response === false) {
            return false;
        }

        $user_data = json_decode($user_response, true);

        return $user_data;
    }
}
?>