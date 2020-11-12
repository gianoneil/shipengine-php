<?php

namespace ShipEngine;

class Package extends ShipEngineResource
{
    public static function create($params)
    {
        return self::_create(get_class(), $params);
    }

    public static function list(array $params = null)
    {
        return self::_list(get_class(), $params);
    }
}
