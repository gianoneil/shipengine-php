<?php

namespace ShipEngine;

class Carrier extends ShipEngineResource
{
    public static function list($params = null)
    {
        return self::_list(get_class(), $params);
    }
}
