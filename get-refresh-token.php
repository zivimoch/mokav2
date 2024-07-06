<?php

require 'vendor/autoload.php';

use Google\Client;

function getClient()
{
    $client = new Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setScopes(Google\Service\Drive::DRIVE);
    $client->setAuthConfig('storage/client_secret_138639346018-villui7ievkimlgc29o00l20du2lgvjm.apps.googleusercontent.com.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    $tokenPath = 'storage/client_secret_138639346018-villui7ievkimlgc29o00l20du2lgvjm.apps.googleusercontent.com.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
        $client->setAccessToken($accessToken);

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
            throw new Exception(join(', ', $accessToken));
        }

        // Save the token to a file.
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }

    // Get refresh token
    $refreshToken = $client->getRefreshToken();
    if ($refreshToken) {
        echo "Refresh Token: " . $refreshToken . PHP_EOL;
    } else {
        echo "Failed to obtain refresh token." . PHP_EOL;
    }
}

getClient();
