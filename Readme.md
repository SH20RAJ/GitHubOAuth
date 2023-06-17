markdown
# GitHubOAuth.php

`GitHubOAuth.php` is a PHP class that provides helper functions for handling GitHub OAuth authentication and interacting with the GitHub API.

## Features

- Simplified GitHub OAuth authentication flow
- Access token retrieval
- User data retrieval from the GitHub API

## Requirements

- PHP 7.0 or higher
- cURL extension enabled

## Installation

1. Download the `GitHubOAuth.php` file.
2. Place the file in your project directory.

## Usage

### Step 1: Create an instance of GitHubOAuth

```php
require_once 'GitHubOAuth.php';

$client_id = 'YOUR_CLIENT_ID';
$client_secret = 'YOUR_CLIENT_SECRET';
$redirect_uri = 'https://yourdomain.com/callback.php';

$github_oauth = new GitHubOAuth($client_id, $client_secret, $redirect_uri);
```

### Step 2: Generate the GitHub Authorization URL

```php
$authorization_url = $github_oauth->getAuthorizationUrl();

// Display the login button or redirect the user to the authorization URL
echo '<a href="' . $authorization_url . '">Login with GitHub</a>';
```

### Step 3: Handle the Callback and Retrieve the Access Token

```php
session_start();

if (isset($_GET['code'])) {
    $auth_code = $_GET['code'];

    $access_token = $github_oauth->getAccessToken($auth_code);

    if ($access_token !== false) {
        $_SESSION['access_token'] = $access_token;

        // Redirect the user to the desired page
        header('Location: welcome.php');
        exit;
    } else {
        echo 'Failed to obtain access token';
    }
}
```

### Step 4: Retrieve User Data

```php
session_start();
require_once 'GitHubOAuth.php';

$client_id = 'YOUR_CLIENT_ID';
$client_secret = 'YOUR_CLIENT_SECRET';
$redirect_uri = 'https://yourdomain.com/callback.php';

$github_oauth = new GitHubOAuth($client_id, $client_secret, $redirect_uri);

if (isset($_SESSION['access_token'])) {
    $access_token = $_SESSION['access_token'];

    $user_data = $github_oauth->getUserData($access_token);

    if ($user_data !== false) {
        // Process user data as needed
        echo 'User ID: ' . $user_data['id'] . '<br>';
        echo 'Login: ' . $user_data['login'] . '<br>';
        // ...
    } else {
        echo 'Failed to retrieve user data from GitHub';
    }
} else {
    echo 'Access token not found';
}
```

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.