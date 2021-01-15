<?php

namespace ShipEngine;

class ShipEngine
{
    /**
     * @var string
     */
    public static $apiKey;

    /**
     * @var string
     */
    public static $mode;

    /**
     * Set the API key
     *
     * @param string $apiKey
     */
    public static function setApiKey(string $apiKey)
    {
        self::$apiKey = $apiKey;

        if (substr($apiKey, 0, 5) === 'TEST_') {
            self::$mode = 'test';
        } else {
            self::$mode = 'live';
        }
    }
}