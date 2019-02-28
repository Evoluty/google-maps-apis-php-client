<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests;

use GoogleMapsClient\Classes\Geolocation;
use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Classes\Language;
use GoogleMapsClient\TimeZone\TimeZoneResponse;
use GuzzleHttp\Psr7\Response;

class ClientTest extends AbstractClientTest
{
    public function testOk(): void
    {
        $expectedResponse = new Response(200, [], json_encode([
            'dstOffset' => 0,
            'rawOffset' => -28800,
            'status' => 'OK',
            'timeZoneId' => 'America/Los_Angeles',
            'timeZoneName' => 'Pacific Standard Time',
        ]));

        $response = $this->handleTest($expectedResponse);

        self::assertSame('OK', $response->getStatus());
        self::assertNull($response->getErrorMessage());
    }

    public function testNot200(): void
    {
        $this->expectException('Http\Client\Exception\HttpException');

        $expectedResponse = new Response(400, [], json_encode([
            'errorMessage' => "Invalid request. Invalid 'timestamp' parameter.",
            'status' => 'INVALID_REQUEST',
        ]));

        $this->handleTest($expectedResponse);
    }

    public function testBadResponse(): void
    {
        $this->expectException('\UnexpectedValueException');

        $expectedResponse = new Response(200, [], "{");

        $this->handleTest($expectedResponse);
    }

    public function testBadResponseStatus(): void
    {
        $this->expectException('\UnexpectedValueException');

        $expectedResponse = new Response(200, [], json_encode([
            'errorMessage' => "Invalid request. Invalid 'timestamp' parameter.",
            'status' => 'INVALID_REQUEST',
        ]));

        $this->handleTest($expectedResponse);
    }

    private function handleTest(Response $expectedResponse): TimeZoneResponse
    {
        $client = static::getClient($expectedResponse);

        $request = GoogleMapsRequest::newTimeZoneRequest(
            new Geolocation('39.6034810', '-119.6822510'),
            1331161200
        )->withLanguage(Language::CZECH());

        return $client->sendTimeZoneRequest($request);
    }
}
