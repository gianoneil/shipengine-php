<?php

namespace ShipEngine;

use phpDocumentor\Reflection\Types\Self_;

abstract class Helpers
{
    public static $listTypes = [
        'packages'  => '\ShipEngine\Package',
        'shipments' => '\ShipEngine\Shipment',
    ];

    public static $objectTypes = [
        'Address'          => '\ShipEngine\Address',
        'Batch'            => '\ShipEngine\Batch',
        'Carrier'          => '\ShipEngine\Carrier',
        'Insurance'        => '\ShipEngine\Insurance',
        'Label'            => '\ShipEngine\Label',
        'Manifest'         => '\ShipEngine\Manifest',
        'Package'          => '\ShipEngine\Package',
        'Rate'             => '\ShipEngine\Rate',
        'Shipment'         => '\ShipEngine\Shipment',
        'Tag'              => '\ShipEngine\Tag',
        'Tracking'         => '\ShipEngine\Tracking',
        'Warehouse'        => '\ShipEngine\Warehouse',
    ];

    public static $objectKeys = [
        'address'          => '\ShipEngine\Address',
        'ship_to'          => '\ShipEngine\Address',
        'ship_from'        => '\ShipEngine\Address',
        'return_to'        => '\ShipEngine\Address',
        'matched_address'  => '\ShipEngine\Address',
        'original_address' => '\ShipEngine\Address',
    ];

    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }

        foreach (array_keys($array) as $key) {
            if (!is_numeric($key)) {
                return false;
            }
        }

        return true;
    }

    public static function pluralize(string $string)
    {
        if (substr($string, -1) !== 's' && substr($string, -1) !== 'h') {
            return "{$string}s";
        }

        return "{$string}es";
    }

    public static function getClassName($class)
    {
        $class = str_replace('_', ' ', $class);
        $class = ucwords($class);
        $class = str_replace(' ', '', $class);

        return $class;
    }

    /**
     * @param $response
     * @param string|null $parent
     * @param string $name
     * @return mixed
     */
    public static function convertToShipEngineObject($response, $parent = null, $name = null)
    {
        $listTypes = array_map(function($objectName) {
            return self::pluralize(strtolower($objectName));
        }, array_keys(self::$objectTypes));
        $listTypes = array_combine($listTypes, self::$objectTypes);

        if (self::isList($response)) {
            $class = null;
            if ($name && array_key_exists($name, $listTypes)) {
                $class = $listTypes[$name];
            }

            return self::convertListToShipEngineObjects($response, $class);

        } elseif (is_array($response)) {
            foreach ($response as $key => &$value) {
                if (array_key_exists($name, self::$objectKeys)) {
                    $class = self::$objectKeys[$name];
                    return ShipEngineObject::constructFrom($response, $class);
                }

                if (substr($key, -3) == '_id') {
                    $class = substr($key, 0, strlen($key) - 3);
                    $class = (self::getClassName($class));
                    if (isset(self::$objectTypes[$class])) {
                        $class = self::$objectTypes[$class];
                        return ShipEngineObject::constructFrom($response, $class);
                    }
                }

                if (array_key_exists($key, $listTypes)) {
                    $class = $listTypes[$key];
                    return self::convertListToShipEngineObjects($value, $class);
                }

                if (array_key_exists($key, self::$objectKeys)) {
                    $class = self::$objectKeys[$key];
                    $value = ShipEngineObject::constructFrom($value, $class);
                }
            }
        }

        return $response;
    }

    public static function convertListToShipEngineObjects($array, $class = null)
    {
        $mapped = [];
        foreach ($array as $value) {
            $mapped[] = ShipEngineObject::constructFrom($value, $class);
        }

        return $mapped;
    }
}