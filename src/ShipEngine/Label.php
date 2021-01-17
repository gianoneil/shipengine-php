<?php

namespace ShipEngine;

class Label extends ShipEngineResource
{
    public static function retrieve($id)
    {
        return self::_retrieve(get_class(), $id);
    }

    public static function create($params)
    {
        return self::_create(get_class(), $params);
    }

    public static function createFromRate($rate_id, $params = null)
    {
        $endpoint = self::endpoint(get_class()) . '/rates/' . $rate_id;
        $response = Requestor::request('POST', $endpoint, $params);

        return Helpers::convertToShipEngineObject($response);
    }

    public static function getByExternalShipmentId($external_shipment_id, $params = null)
    {
        $endpoint = self::endpoint(get_class()) . '/external_shipment_id/' . $external_shipment_id;
        $response = Requestor::request('GET', $endpoint, $params);

        return Helpers::convertToShipEngineObject($response);
    }

    public function void()
    {
        $endpoint = self::endpoint(get_class()) . '/' . $this->label_id . '/void';
        $response = Requestor::request('PUT', $endpoint);

        return Helpers::convertToShipEngineObject($response);
    }

    public static function list(array $params = null)
    {
        return self::_list(get_class(), $params);
    }
}