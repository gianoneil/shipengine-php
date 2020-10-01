<?php

namespace ShipEngine;

class Package extends ShipEngineResource
{
    public static function create($params)
    {
        return self::_create(get_class(), $params);
    }
}
