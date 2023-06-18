<?php

require_once 'GitHubOAuth.php';

$client_id = 'd9d2f82db231d388f024';
$client_secret = 'eb60e47d2d303907224e2ca9aae8411c17894644';
$redirect_uri = 'https://githuboauth.sh20raj.repl.co/';

$github_oauth = new GitHubOAuth($client_id, $client_secret, $redirect_uri);

$authorization_url = $github_oauth->getAuthorizationUrl();

// Display the login button or redirect the user to the authorization URL
session_start();

if (isset($_GET['code'])) {
    $auth_code = $_GET['code'];

    $access_token = $github_oauth->getAccessToken($auth_code);

    if ($access_token !== false) {
        $_SESSION['access_token'] = $access_token;

        // Redirect the user to the desired page
        //header('Location: welcome.php');
        //exit;
      echo "hii";
    } else {
        echo 'Failed to obtain access token';
    }
}
  

?>
<html>
  <head>
    <title>Login Using GitHub</title>
    <link rel="icon" href="https://bit.ly/samplefavicon"/>
    <style>
      body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
        overflow: hidden;
      }

      .github {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        font-size: 18px;
        border: none;
        border-radius: 30px;
        background-color: #24292e;
        color: #ffffff;
        cursor: pointer;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
        transition: background-color 0.3s, transform 0.3s;
      }

      .github:hover {
        background-color: #0366d6;
        transform: scale(1.05);
      }

      .github svg {
        margin-right: 10px;
        width: 20px;
        height: 20px;
        fill: #ffffff;
      }

      .animated-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
      }

      .animated-background::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
          45deg,
          #f8e71c,
          #f632ab,
          #405de6,
          #009688,
          #f44336,
          #f8e71c
        );
        background-size: 300% 300%;
        animation: animateBackground 20s ease-in-out infinite;
      }

      @keyframes animateBackground {
        0% {
          background-position: 0% 50%;
        }
        50% {
          background-position: 100% 50%;
        }
        100% {
          background-position: 0% 50%;
        }
      }
      a {
        text-decoration:none;
      }
    </style>
  </head>
  <body>
    <div class="animated-background"></div>

    <a style="display:<?php echo $loginbutton ; ?>;" href="<?php echo $authorization_url; ?>">
    <button class="github">
      <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
        <path
          d="M256 32C132.3 32 32 134.9 32 261.7c0 101.5 64.2 187.5 153.2 217.9a17.56 17.56 0 003.8.4c8.3 0 11.5-6.1 11.5-11.4 0-5.5-.2-19.9-.3-39.1a102.4 102.4 0 01-22.6 2.7c-43.1 0-52.9-33.5-52.9-33.5-10.2-26.5-24.9-33.6-24.9-33.6-19.5-13.7-.1-14.1 1.4-14.1h.1c22.5 2 34.3 23.8 34.3 23.8 11.2 19.6 26.2 25.1 39.6 25.1a63 63 0 0025.6-6c2-14.8 7.8-24.9 14.2-30.7-49.7-5.8-102-25.5-102-113.5 0-25.1 8.7-45.6 23-61.6-2.3-5.8-10-29.2 2.2-60.8a18.64 18.64 0 015-.5c8.1 0 26.4 3.1 56.6 24.1a208.21 208.21 0 01112.2 0c30.2-21 48.5-24.1 56.6-24.1a18.64 18.64 0 015 .5c12.2 31.6 4.5 55 2.2 60.8 14.3 16.1 23 36.6 23 61.6 0 88.2-52.4 107.6-102.3 113.3 8 7.1 15.2 21.1 15.2 42.5 0 30.7-.3 55.5-.3 63 0 5.4 3.1 11.5 11.4 11.5a19.35 19.35 0 004-.4C415.9 449.2 480 363.1 480 261.7 480 134.9 379.7 32 256 32z"
        />
      </svg>
      Login with GitHub
    </button>
    </a>

  </body>
</html>
