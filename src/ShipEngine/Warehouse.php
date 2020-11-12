<?php

namespace ShipEngine;

class Warehouse extends ShipEngineResource
{
    /**
     * create a warehouse
     *
     * @link https://www.shipengine.com/docs/reference/create-warehouse/
     * @param $params
     * @return mixed
     */
    public static function create($params)
    {
        return self::_create(get_class(), $params);
    }

    public static function update($id, $params)
    {
        return self::_update(get_class(), $id, $params);
    }

    public static function list(array $params = null)
    {
        return self::_list(get_class(), $params);
    }

}
