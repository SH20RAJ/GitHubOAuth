<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'GitHubOAuth.php';

$client_id = 'd9d2f82db231d388f024';
$client_secret = 'eb60e47d2d303907224e2ca9aae8411c17894644';
$redirect_uri = 'https://githuboauth.sh20raj.repl.co/';

$github_oauth = new GitHubOAuth($client_id, $client_secret, $redirect_uri);

//$github_oauth->auth_code = 'ffcd70cf0a3fd76fc0e7';
echo $access_token = $github_oauth->getAccessToken('bdfc6dfe0b81d60c1375');
