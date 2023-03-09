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
    'amount' => 1000,   //$10 in cents value
    'credit_card' => [
        'card_number' => '5123456789012346',
        'expiry_date' => '2405',
        'security_code' => '100'
    ]
];

try {
    // Purchase request
    $raw_response = $guzzle->post('/v1/transactions/purchases', [
        'headers' => ['Content-type' => 'application/json', 'Authorization' => 'Bearer ' . $accessToken],
        'body' => json_encode($data),
    ]);
    $response = $raw_response->getBody()->getContents();
    if ($response) {
        $response_decoded = json_decode($response);

        if ($response_decoded && isset($response_decoded->result)) {
            if ($response_decoded->result->success) {
                header('Content-type: text/plain');
                echo "Transaction id: {$response_decoded->transaction_id}" . PHP_EOL;
                echo "Merchant session: {$response_decoded->merchant_session}" . PHP_EOL;
                echo "Merchant reference: {$response_decoded->merchant_reference}" . PHP_EOL;
            }
            echo $response_decoded->result->title;
        }
        return null;
    }
} catch (\GuzzleHttp\Exception\ClientException $e) {
    echo $e->getResponse()->getBody();
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    //@todo: Replace with your own error handling
    return null;
}
