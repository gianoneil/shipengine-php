<?php

namespace ShipEngine;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Requestor
{
    public static function request(string $method, string $endpoint, array $params)
    {
        $client = new Client(['base_uri' => 'https://api.shipengine.com/v1/']);
        $headers = [
            'API-Key'      => 'TEST_F1CUc3ZlfjwGaHZ9dEmgvOH9WHiVM+IB7zWCiyg8WZ4',
            'Content-Type' => 'application/json',
        ];
        $request = new Request($method, $endpoint, $headers, json_encode($params));
        $response = $client->send($request);
        $response = json_decode($response->getBody(), true);

        return $response;
    }
}