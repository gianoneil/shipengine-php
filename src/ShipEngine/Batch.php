<?php

namespace ShipEngine;

class Batch extends ShipEngineResource
{
    public static function list($params = null)
    {
        return self::_list(get_class(), $params);
    }

    public static function create($params)
    {
        return self::_create(get_class(), $params);
    }
}
