<?php
session_start();

$accessToken = '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';
$repoName = 'Hello-World';
$repoDescription = 'This is your first repo!';
$homepage = 'https://github.com';
$isPrivate = false;
$isTemplate = true;

$url = 'https://api.github.com/user/repos';

$data = array(
    'name' => $repoName,
    'description' => $repoDescription,
    'homepage' => $homepage,
    'private' => $isPrivate,
    'is_template' => $isTemplate
);

$ch = curl_init($url);

$headers = array(
    'Content-type: application/json',
    'Accept: application/vnd.github+json',
    'Authorization: Bearer ' . $accessToken,
    'X-GitHub-Api-Version: 2022-11-28'
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($httpCode === 201) {
    echo 'Repository created successfully!';
} else {
    echo 'Failed to create repository. HTTP response code: ' . $httpCode;
}

?>
