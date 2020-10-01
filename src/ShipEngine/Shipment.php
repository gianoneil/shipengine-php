<?php

namespace ShipEngine;

class Shipment extends ShipEngineResource
{
    /**
     * create a shipment
     *
     * @link https://www.shipengine.com/docs/shipping/create-a-shipment/
     * @param $params
     * @return mixed
     */
    public static function create($params)
    {
        return self::_create(get_class(), $params);
    }
}
