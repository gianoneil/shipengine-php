<?php

namespace ShipEngine;

class Manifest extends ShipEngineResource
{
    /**
     * create a manifest
     *
     * @link https://www.shipengine.com/docs/shipping/manifests/create-a-manifest/
     * @param $params
     * @return mixed
     */
    public static function create($params)
    {
        return self::_create(get_class(), $params);
    }

    public static function retrieve($id)
    {
        return self::_retrieve(get_class(), $id);
    }

    public static function list(array $params = null)
    {
        return self::_list(get_class(), $params);
    }
}
