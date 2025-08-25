<?php
/**
 * This is an example page that handles post response
 * Use this to verify transaction status
 */
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

// Receive incoming data from Paystation
$payload = file_get_contents('php://input');
$headers = getallheaders();

// Verify the payload
$hmac_signature = $headers['X-Signature'];
$timestamp = $headers['X-Timestamp'];
$get_hmac = hash_hmac('sha512', $timestamp.$payload, $_ENV['HMAC_KEY']);

if($hmac_signature != $get_hmac) {
    echo 'HMAC verification failed';
    exit;
}
$data = json_decode($payload);

if (empty($data->result)) {
    echo 'No result';
} else {
    //@Todo: Do what you want with this data
    if ($data->result->success) {
        echo 'Transaction successful';
    } else {
        echo 'Transaction failed';
    }
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

