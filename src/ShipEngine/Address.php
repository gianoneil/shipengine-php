<?php

namespace ShipEngine;

class Address extends ShipEngineResource
{
    /**
     * parse an address
     *
     * @link https://shipengine.github.io/shipengine-openapi/#operation/parse_address
     * @param $params
     * @return array
     */
    public static function parse($params)
    {
        $endpoint = ShipEngineResource::endpoint(get_class()) . '/recognize';
        $response = Requestor::request('POST', $endpoint, $params);

        return Helpers::convertToShipEngineObject($response);
    }

    /**
     * validate an address
     *
     * @link https://shipengine.github.io/shipengine-openapi/#operation/validate_address
     * @param $params
     * @return
     */
    public static function validate($params)
    {
        $endpoint = ShipEngineResource::endpoint(get_class()) . '/validate';
        $response = Requestor::request('POST', $endpoint, $params);

        return Helpers::convertToShipEngineObject($response, null, 'address_validator');
    }
}
