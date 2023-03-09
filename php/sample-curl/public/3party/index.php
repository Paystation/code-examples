<?php

require_once(__DIR__ . '/../../functions.php');


// Get OAuth token
$accessToken = getAccessToken('write');

// Setup data
$data_array = [
    'paystation_id' => PAYSTATION_ID,
    'gateway_id' => GATEWAY_ID,
    'merchant_session' => uniqid('unique-id-'),
    'merchant_reference' => 'your reference here',
    'amount' => 2000   //$20 in cents value
];
// OPTIONAL, ideally should be set on your Paystation account
$data_array += [
    'return_url' => 'http://localhost:8002/3party/return.php',
    // Webhook receipt page. This should be publicly accessible (see example post-response.php)
    'response_url' => 'https://webhook.site/sample-code-webhook'
];
$data = json_encode($data_array);

// Purchase initiate request
$purchase = postRequest('v1/hosted/purchases', $accessToken, $data);
if ($purchase) {
    $result = json_decode($purchase);
    if ($result && isset($result->payment_url)) {
        header("Location: {$result->payment_url}");
    } else {
        //@todo: Replace with your own error handling
        // print_r($result->errors);
        return null;
    }
}

