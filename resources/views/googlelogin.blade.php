<?php 

$client = new Google_Client();
$client->setAuthConfig('../config/credentials.json');
$client->setScopes(['profile', 'email']);
// Your redirect URI can be any registered URI, but in this example
// we redirect back to this same page

$url=Request::root();
$redirect_uri = $url . '/logingoogle';
$client->setAccessType('offline');
$client->setApplicationName('Viaflats');
$client->setRedirectUri($redirect_uri);
$auth_url = $client->createAuthUrl();

echo '<a href="' . $auth_url . '"><button class="btn-danger" style="border-radius:20px;">'.trans('auth.button_google').'</button></a>';