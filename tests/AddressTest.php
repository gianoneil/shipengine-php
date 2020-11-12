<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

ShipEngine\ShipEngine::setApiKey('TEST_F1CUc3ZlfjwGaHZ9dEmgvOH9WHiVM+IB7zWCiyg8WZ4');

class AddressTest extends TestCase
{
    public function testParse(): void
    {
        $request = [
            'text' => 'Margie McMiller at 3800 North Lamar suite 200 in austin, tx.  The zip code there is 78652.'
        ];
        $parsedAddress = \ShipEngine\Address::parse($request);

        $this->assertIsArray($parsedAddress);
        $this->assertIsFloat($parsedAddress['score']);
        $this->assertInstanceOf('\ShipEngine\Address', $parsedAddress['address']);
        $this->assertIsArray($parsedAddress['entities']);
    }

    public function testValidateValidAddress(): void
    {
        $request = [
            [
                'name'           => 'Mickey and Minnie Mouse',
                'phone'          => '714-781-4565',
                'company_name'   => 'The Walt Disney Company',
                'address_line1'  => '500 South Buena Vista Street',
                'city_locality'  => 'Burbank',
                'state_province' => 'CA',
                'postal_code'    => 91521,
                'country_code'   => 'US',
            ]
        ];
        $result = \ShipEngine\Address::validate($request);

        $this->assertIsArray($result);
        $validator = reset($result);
        $this->assertInstanceOf('\ShipEngine\ShipEngineObject', $validator);
        $this->assertIsString($validator->status);
        $this->assertEquals('verified', $validator->status);
        $this->assertInstanceOf('\ShipEngine\Address', $validator->original_address);
        $this->assertInstanceOf('\ShipEngine\Address', $validator->matched_address);
    }

    public function testValidateInvalidAddress(): void
    {
        $request = [
            [
                'name'           => 'Mickey and Minnie Mouse',
                'phone'          => '714-781-4565',
                'company_name'   => 'The Walt Disney Company',
                'address_line1'  => '500 South Buena Vista Street',
                'city_locality'  => 'Burbank',
                'state_province' => 'CA',
                'postal_code'    => 00,
                'country_code'   => 'US',
            ]
        ];
        $result = \ShipEngine\Address::validate($request);

        $this->assertIsArray($result);
        $validator = reset($result);
        $this->assertInstanceOf('\ShipEngine\ShipEngineObject', $validator);
        $this->assertIsString($validator->status);
        $this->assertEquals('unverified', $validator->status);
        $this->assertInstanceOf('\ShipEngine\Address', $validator->original_address);
        $this->assertNull($validator->matched_address);
    }
}
