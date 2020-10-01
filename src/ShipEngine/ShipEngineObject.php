<?php

namespace ShipEngine;

class ShipEngineObject
{
    protected $_values;

    public function __construct($id, $parent = null, $name = null)
    {
        $this->_values = [];
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->_values)) {
            return $this->_values[$key];
        }
        $class = get_class($this);
        error_log("ShipEngine Notice: Undefined property of {$class} instance: {$key}");

        return null;
    }

    public static function constructFrom($values, $class = null, $parent = null, $name = null)
    {
        $class = $class ?? get_class();

        $object = new $class($values[$class . '_id'] ?? null, $parent, $name);
        $object->refreshFrom($values);

        return $object;
    }

    public function refreshFrom($values, $partial = false)
    {
        foreach ($values as $key => $value) {
            $this->_values[$key] = Helpers::convertToShipEngineObject($value, $this, $key);
        }
    }
}