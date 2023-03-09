<?php

use GuzzleHttp\Client;

require_once(__DIR__ . '/../../vendor/autoload.php');

// Load environment variables
try {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../../config');
    $dotenv->load();
    $dotenv->required(['API_URL', 'CLIENT_ID', 'CLIENT_SECRET', 'PAYSTATION_ID', 'GATEWAY_ID']);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

// Get OAuth token
$accessToken = OAuthToken::getToken();

// Setup data
$guzzle = new Client(['base_uri' => $_ENV['API_URL']]);
$data = [
    'paystation_id' => $_ENV['PAYSTATION_ID'],
    'gateway_id' => $_ENV['GATEWAY_ID'],
    'merchant_session' => uniqid('unique-id-'),
    'merchant_reference' => 'your reference here',
    'amount' => 2000   //$20 in cents value
];
// OPTIONAL, ideally should be set on your Paystation account
$data += [
    'return_url' => 'http://localhost:8001/3party/return.php',
    // Webhook receipt page. This should be publicly accessible (see example post-response.php)
    'response_url' => 'https://webhook.site/sample-code-webhook'
];

try {
    // Purchase initiate request
    $raw_response = $guzzle->post('/v1/hosted/purchases', [
        'headers' => ['Content-type' => 'application/json', 'Authorization' => 'Bearer ' . $accessToken],
        'body' => json_encode($data),
    ]);
    $response = $raw_response->getBody()->getContents();
    if ($response) {
        $response_decoded = json_decode($response);
        if ($response_decoded && isset($response_decoded->payment_url)) {
            // Redirect to payment url
            header("Location: {$response_decoded->payment_url}");
        }
        return null;
    }
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    //@todo: Replace with your own error handling
    return null;
}
