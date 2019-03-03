<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Directions;

use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Tests\AbstractClientTest;
use GuzzleHttp\Psr7\Response;

class ClientTest extends AbstractClientTest
{
    public function testOk(): void
    {
        $apiResult = file_get_contents(__DIR__ . '/direction_api_result.json');

        $expectedResponse = new Response(
            200, [], $apiResult
        );

        $client = static::getClient($expectedResponse);

        $request = GoogleMapsRequest::newDirectionsRequest(
            'Brooklyn', 'Queens'
        );

        $response = $client->sendDirectionsRequest($request);

        self::assertSame('OK', $response->getStatus());
        self::assertNull($response->getErrorMessage());
    }
}
