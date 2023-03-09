<?php

require_once(__DIR__ . '/../../functions.php');


// Get OAuth token
$accessToken = getAccessToken('write');

// Setup data
$data = json_encode([
    'paystation_id' => PAYSTATION_ID,
    'gateway_id' => GATEWAY_ID,
    'merchant_session' => uniqid('unique-id-'),
    'merchant_reference' => 'your reference here',
    'amount' => 1000,   //$10 in cents value
    'credit_card' => [
        'card_number' => '5123456789012346',
        'expiry_date' => '2405',
        'security_code' => '100'
    ]
]);

// Purchase request
$purchase = postRequest('v1/transactions/purchases', $accessToken, $data);
if ($purchase) {
    $response_decoded = json_decode($purchase);
    if ($response_decoded && isset($response_decoded->result)) {
        if ($response_decoded->result->success) {
            header('Content-type: text/plain');
            echo "Transaction id: {$response_decoded->transaction_id}" . PHP_EOL;
            echo "Merchant session: {$response_decoded->merchant_session}" . PHP_EOL;
            echo "Merchant reference: {$response_decoded->merchant_reference}" . PHP_EOL;
        }
        echo $response_decoded->result->title;
    } else {
        //@todo: Replace with your own error handling
        print_r($response_decoded->errors);
        return null;
    }
}

