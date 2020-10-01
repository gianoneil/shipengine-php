<?php

namespace ShipEngine;

class ShipEngine
{
    /**
     * @var string
     */
    public static $apiKey;

    /**
     * Set the API key
     *
     * @param string $apiKey
     */
    public static function setApiKey(string $apiKey)
    {
        self::$apiKey = $apiKey;
    }
}