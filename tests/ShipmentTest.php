<?php

use PHPUnit\Framework\TestCase;

class ShipmentTest extends TestCase
{
    public function testCreateShipment(): void
    {
        $request = [
            'shipments' => [
                [
                    'validate_address'   => 'no_validation',
                    'service_code'       => 'usps_priority_mail',
                    'ship_to'            => [
                        'name'                          => 'Amanda Miller',
                        'phone'                         => '555-555-5555',
                        'address_line1'                 => '525 S Winchester Blvd',
                        'city_locality'                 => 'San Jose',
                        'state_province'                => 'CA',
                        'postal_code'                   => '95128',
                        'country_code'                  => 'US',
                        'address_residential_indicator' => 'yes',
                    ],
                    'ship_from'          => [
                        'company_name'                  => 'Example Corp.',
                        'name'                          => 'John Doe',
                        'phone'                         => '111-111-1111',
                        'address_line1'                 => '4909 Marathon Blvd',
                        'address_line2'                 => 'Suite 300',
                        'city_locality'                 => 'Austin',
                        'state_province'                => 'TX',
                        'postal_code'                   => '78756',
                        'country_code'                  => 'US',
                        'address_residential_indicator' => 'no',
                    ],
                    'confirmation'       => 'none',
                    'insurance_provider' => 'none',
                    'packages'           => [
                        [
                            'weight' => [
                                'value' => 1.0,
                                'unit'  => 'ounce',
                            ],
                        ],
                    ],
                ]
            ]
        ];
        $shipments = ShipEngine\Shipment::create($request);
        $this->assertIsArray($shipments);
        $shipment = reset($shipments);
        $this->assertInstanceOf('Shipengine\Shipment', $shipment);
        $this->assertIsString($shipment->shipment_id);
        $this->assertStringMatchesFormat('se-%i', $shipment->shipment_id);
    }
}
