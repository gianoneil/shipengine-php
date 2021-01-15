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

    public static function retrieve($id)
    {
        return self::_retrieve(get_class(), $id);
    }

    public static function update($id, $params)
    {
        return self::_update(get_class(), $id, $params);
    }

    public function getRates(array $rate_options)
    {
//        $existingRates = $this->retrieveRates();
//
//        if ($existingRates) {
//            return $existingRates;
//        }
        return \ShipEngine\Rate::get([
            'shipment_id'  => $this->shipment_id,
            'rate_options' => $rate_options,
        ]);
    }

    public function retrieveRates()
    {
        $endpoint = ShipEngineResource::endpoint(get_class()) . '/' . $this->shipment_id . '/rates';
        $response = Requestor::request('GET', $endpoint);

        return Helpers::convertToShipEngineObject($response);
    }

    public function cancel()
    {
        $endpoint = ShipEngineResource::endpoint(get_class()) . '/' . $this->shipment_id . '/cancel';
        $response = Requestor::request('PUT', $endpoint);

        return Helpers::convertToShipEngineObject($response);
    }
}
