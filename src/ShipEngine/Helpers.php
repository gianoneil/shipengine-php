<?php

namespace ShipEngine;

abstract class Helpers
{

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
        'Service'          => '\ShipEngine\Service',
    ];

    public static $objectKeys = [
        'address'          => '\ShipEngine\Address',
        'ship_to'          => '\ShipEngine\Address',
        'ship_from'        => '\ShipEngine\Address',
        'return_to'        => '\ShipEngine\Address',
        'matched_address'  => '\ShipEngine\Address',
        'original_address' => '\ShipEngine\Address',
    ];

    /**
     * Check if array is a plausible list of objects
     *
     * @param $array
     * @return bool
     */
    public static function isList($array): bool
    {
        if (!is_array($array)) {
            return false;
        }

        foreach ($array as $key => $value) {
            if (
                !is_numeric($key)
                || !is_array($value)
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Pluralize a word
     *
     * @param string $string
     * @return string
     */
    public static function pluralize(string $string): string
    {
        if (substr($string, -1) !== 's' && substr($string, -1) !== 'h') {
            return "{$string}s";
        }

        return "{$string}es";
    }

    /**
     * Get class name
     *
     * @param string $class
     * @return string
     */
    public static function getClassName(string $class): string
    {
        $class = str_replace('_', ' ', $class);
        $class = ucwords($class);
        $class = str_replace(' ', '', $class);

        return $class;
    }

    /**
     * Get plausible "keys" of object arrays
     *
     * @return array
     */
    private static function getListTypes(): array
    {
        $listTypes = array_map(
            function($objectName) {
                return self::pluralize(strtolower($objectName));
            },
            array_keys(self::$objectTypes)
        );

        return array_combine($listTypes, self::$objectTypes);
    }

    /**
     * Convert response to ShipEngine object
     *
     * @param $response
     * @param string|null $parent
     * @param string $name
     * @return mixed
     */
    public static function convertToShipEngineObject($response, $parent = null, $name = null)
    {
        $listTypes = self::getListTypes();

        if (self::isList($response)) {
            $class = null;
            if ($name && array_key_exists($name, $listTypes)) {
                $class = $listTypes[$name];
            }

            return self::convertListToShipEngineObjects($response, $class);

        } elseif (is_array($response)) {

            // if name is specified and is one of known objects; transform the response into its corresponding object
            if (array_key_exists($name, self::$objectKeys)) {
                $class = self::$objectKeys[$name];
                return ShipEngineObject::constructFrom($response, $class);
            }

            // now try to figure out what kind of object the response should be
            foreach ($response as $key => &$value) {

                // if we encounter an ID, identify the class and convert the response
                if (substr($key, -3) == '_id') {
                    $class = substr($key, 0, strlen($key) - 3);
                    $class = (self::getClassName($class));
                    if (isset(self::$objectTypes[$class])) {
                        $class = self::$objectTypes[$class];
                        return ShipEngineObject::constructFrom($response, $class);
                    }
                }

                // if key is one of known list or object types
                if (array_key_exists($key, $listTypes)) {
                    // key is one of known list types, convert value into an array of corresponding objects
                    $class = $listTypes[$key];
                    $value = self::convertListToShipEngineObjects($value, $class);
                } elseif (array_key_exists($key, self::$objectKeys)) {
                    // key is one of known object types, convert value into corresponding object
                    $class = self::$objectKeys[$key];
                    $value = ShipEngineObject::constructFrom($value, $class);
                }
            }
        }

        return $response;
    }

    /**
     * Convert each member of an array to an object
     *
     * @param array $array
     * @param null $class
     * @return array
     */
    public static function convertListToShipEngineObjects(array $array, $class = null): array
    {
        $mapped = [];
        foreach ($array as $value) {
            $mapped[] = ShipEngineObject::constructFrom($value, $class);
        }

        return $mapped;
    }
}