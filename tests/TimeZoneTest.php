<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests;

use GoogleMapsClient\GoogleMapsClient;
use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Language;
use GoogleMapsClient\TimeZone\TimeZoneLocation;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client;
use PHPUnit\Framework\TestCase;

class TimeZoneTest extends TestCase
{
    public function testOk(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'dstOffset' => 0,
                'rawOffset' => -28800,
                'status' => 'OK',
                'timeZoneId' => 'America/Los_Angeles',
                'timeZoneName' => 'Pacific Standard Time',
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzleClient = Client::createWithConfig(['handler' => $handler]);

        $client = new GoogleMapsClient('key', $guzzleClient);

        $request = GoogleMapsRequest::newTimeZoneRequest(
            new TimeZoneLocation('39.6034810', '-119.6822510'),
            1331161200
        )->withLanguage(Language::CZECH());

        $response = $client->sendTimeZoneRequest($request);

        // Response metadata
        self::assertSame('OK', $response->getStatus());
        self::assertNull($response->getErrorMessage());

        // Response data
        self::assertSame(0, $response->getDstOffset());
        self::assertSame(-28800, $response->getRawOffset());
        self::assertSame('America/Los_Angeles', $response->getTimeZoneId());
        self::assertSame('Pacific Standard Time', $response->getTimeZoneName());
    }
}