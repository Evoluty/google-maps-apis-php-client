<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Elevation;

use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Tests\AbstractClientTest;
use GuzzleHttp\Psr7\Response;

class ClientTest extends AbstractClientTest
{
    public function testOk(): void
    {
        $expectedResponse = new Response(200, [], json_encode([
            'results' => [
                [
                    'elevation' => 1608.637939453125,
                    'location' => [
                        'lat' => 39.73915360,
                        'lng' => -104.98470340,
                    ],
                    'resolution' => 4.771975994110107,
                ]
            ],
            'status' => 'OK',
        ]));

        $client = static::getClient($expectedResponse);

        $request = GoogleMapsRequest::newElevationRequest()
            ->withGeolocationLocation('39.6034810', '-119.6822510');

        $response = $client->sendElevationRequest($request);

        self::assertSame('OK', $response->getStatus());
        self::assertNull($response->getErrorMessage());
    }
}
