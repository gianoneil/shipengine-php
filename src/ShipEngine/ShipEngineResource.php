<?php

namespace ShipEngine;

use ReflectionClass;

abstract class ShipEngineResource extends ShipEngineObject
{

    public static function className($class)
    {
        $class = (new ReflectionClass($class))->getShortName();
        $name = strtolower($class);

        return $name;
    }

    public static function endpoint($class)
    {
        $class = self::className($class);
        if (substr($class, -1) !== 's' && substr($class, -1) !== 'h') {
            return "{$class}s";
        }

        return "{$class}es";
    }

    protected static function _create($class, $params = null)
    {
        $endpoint = self::endpoint($class);
        $response = Requestor::request('POST', $endpoint, $params);

        return Helpers::convertToShipEngineObject($response);
    }

}