<?php

require_once(__DIR__.'/config.php');

function getAccessToken($scope)
{

    $bodyParams = [
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'grant_type' => 'client_credentials',
        'scope' => $scope
    ];
    $accessTokenUrl = API_URL . '/oauth/token';
    $curlHandle = curl_init($accessTokenUrl);
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => [
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded",
            "accept: *",
            "accept-encoding: gzip, deflate",
        ],
        CURLOPT_POSTFIELDS => http_build_query($bodyParams)
    ];
    curl_setopt_array($curlHandle, $options);
    $curlResponse = curl_exec($curlHandle);
    $error = curl_error($curlHandle);
    curl_close($curlHandle);

    if ($error) {
        echo "cURL error: " . $error;
    } else {
        $response = json_decode($curlResponse);
        if (array_key_exists('access_token', $response)) {
            return $response->access_token;
        }
        if (array_key_exists('error', $response)) {
            echo $response->error_description;
        }
    }
}

function postRequest($endpoint, $token, $body)
{
    $curlHandle = curl_init(API_URL . '/' . $endpoint);
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => [
            "cache-control: no-cache",
            "content-type: application/json",
            "accept: *",
            "accept-encoding: gzip, deflate",
            "Authorization: Bearer " . $token
        ],
        CURLOPT_POSTFIELDS => $body
    ];
    curl_setopt_array($curlHandle, $options);
    $response = curl_exec($curlHandle);
    $error = curl_error($curlHandle);
    curl_close($curlHandle);
    if ($error) {
        echo "cURL error: " . $error;
    } else {
        return $response ?: null;
    }
    return null;
}