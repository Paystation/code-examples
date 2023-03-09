<?php

use GuzzleHttp\Client;

class OAuthToken
{
    public static function getToken()
    {
        $client_id = $_ENV['CLIENT_ID'];
        $client_secret = $_ENV['CLIENT_SECRET'];
        $access_token_url = $_ENV['API_URL'] . '/oauth/token';
        $guzzle = new Client(['base_uri' => $access_token_url]);
        try {
            $raw_response = $guzzle->post('', [
                'headers' => ['Content-type' => 'application/json'],
                'body' => json_encode([
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                    'grant_type' => 'client_credentials',
                    'scope' => 'write'
                ]),
            ]);
            $response = $raw_response->getBody()->getContents();
            if ($response) {
                $response_decoded = json_decode($response);
                if ($response_decoded && isset($response_decoded->access_token)) {
                    return $response_decoded->access_token;
                }
                return null;
            }
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            //@todo: Replace with your own error handling
            return null;
        }
        return null;
    }
}