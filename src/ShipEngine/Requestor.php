<?php

namespace ShipEngine;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;

class Requestor
{
    public $apiKey;

    public function __construct($apiKey = null)
    {
        $this->_apiKey = $apiKey;
    }

    public static function request(string $method, string $endpoint, $params = null)
    {
        $client = new Client(['base_uri' => 'https://api.shipengine.com/v1/']);
        $headers = [
            'API-Key'      => ShipEngine::$apiKey,
            'Content-Type' => 'application/json',
        ];
        $request = new Request($method, $endpoint, $headers, json_encode($params));

        try {
            $response = $client->send($request);
            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            // TODO: error handling
            $errors = null;
            if ($e->hasResponse()) {
                $errors = json_decode($e->getResponse()->getBody(), true);
            }
            dump('Error: ' . $e->getCode());
            dump($errors);
            dump(debug_backtrace());
        }
    }

}