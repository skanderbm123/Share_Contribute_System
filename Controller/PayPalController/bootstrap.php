<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
require '../../vendor/autoload.php';
// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;
// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
$paypalConfig = [
    'client_id' => 'AVR0IBXQxIfhSXLwbNLFxNxSEUufo3_MUzRFXuUtVtmCCpeQ-29QxNVUkFBV4srIj1RMb-GFsP5koWW3',
    'client_secret' => 'EDFihXY0Nhs90O9g64-bif30gc-8fcMMngOHMxLPD3oKTS5Z5Num8icX4eo-nDgiWVyp9PkOfJi-KbJU',
    'return_url' => 'http://localhost/Share_Contribute_System/View/PayPal/response.php',
    'cancel_url' => 'http://sharecontributesystem/View/PayPal/payment-cancelled.php'
];
// Database settings. Change these for your database configuration.
$dbConfig = [
    'host' => 'us-cdbr-iron-east-05.cleardb.net:3306',
    'username' => 'b9fb0372682c82',
    'password' => 'f3d42555',
    'name' => 'heroku_99595f089932bf8'
];
$apiContext = getApiContext($paypalConfig['client_id'], $paypalConfig['client_secret'], $enableSandbox);
/**
 * Set up a connection to the API
 *
 * @param string $clientId
 * @param string $clientSecret
 * @param bool   $enableSandbox Sandbox mode toggle, true for test payments
 * @return \PayPal\Rest\ApiContext
 */
function getApiContext($clientId, $clientSecret, $enableSandbox = false)
{
    $apiContext = new ApiContext(
        new OAuthTokenCredential($clientId, $clientSecret)
    );
    $apiContext->setConfig([
        'mode' => $enableSandbox ? 'sandbox' : 'live'
    ]);
    return $apiContext;
}

?>