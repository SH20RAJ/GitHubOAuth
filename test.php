<?php
session_start();
require_once 'GitHubOAuth.php';

$client_id = 'd9d2f82db231d388f024';
$client_secret = 'eb60e47d2d303907224e2ca9aae8411c17894644';
$redirect_uri = 'https://githuboauth.sh20raj.repl.co/';

$github_oauth = new GitHubOAuth($client_id, $client_secret, $redirect_uri);


   // $access_token = $_SESSION['access_token'];

    $user_data = $github_oauth->getAuthenticatedUser("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");

    if ($user_data !== false) {
        // Process user data as needed
        echo 'User ID: ' . $user_data->id . '<br>';
        echo 'Login: ' . $user_data->login . '<br>';
        // ...
    } else {
        echo 'Failed to retrieve user data from GitHub';
    }
