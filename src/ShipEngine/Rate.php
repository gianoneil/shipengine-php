<?php

namespace ShipEngine;

class Rate extends ShipEngineResource
{
    /**
     * get shipping rates
     *
     * @link https://shipengine.github.io/shipengine-openapi/#operation/calculate_rates
     * @param $params
     * @return array
     */
    public static function get($params)
    {
        $endpoint = ShipEngineResource::endpoint(get_class());
        $response = Requestor::request('POST', $endpoint, $params);

        return Helpers::convertToShipEngineObject($response);
    }

    public static function retrieve($id)
    {
        return self::_retrieve(get_class(), $id);
    }

    public function createLabel()
    {
        return \ShipEngine\Label::createFromRate($this->rate_id);
    }
}
