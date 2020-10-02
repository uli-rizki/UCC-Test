<?php

require('vendor/autoload.php');

class VehicleTest extends \PHPUnit\Framework\TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://127.0.0.1:8002'
        ]);
    }

    public function testPost_NewVehicle_VehicleObject()
    {
        $response = $this->client->post('/vehicle', [
          'json' => [
            'vehicle' => [
              'vehicle_no'    => "RR 3456",
              'vehicle_name'     => 'Honda Brio',
              'category'    => 'cars',
              'engine_displacement'    => 1.5,
              'engine_power'    => 115,
              'price'    => 25000,
              'location'    => 'US',
              'format_units'    => 'L',
              'currency'    => 'USD'
            ]
          ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());
    }
}