<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Timezone;

use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Tests\AbstractClientTest;
use GoogleMapsClient\TimeZone\TimeZoneLocation;
use GuzzleHttp\Psr7\Response;

class TimeZoneClientTest extends AbstractClientTest
{
    use TimeZoneUtils;

    public function testOk(): void
    {
        $expectedResponse = new Response(200, [], json_encode([
            'dstOffset' => 0,
            'rawOffset' => -28800,
            'status' => 'OK',
            'timeZoneId' => 'America/Los_Angeles',
            'timeZoneName' => 'Pacific Standard Time',
        ]));

        $client = static::getClient($expectedResponse);

        $request = GoogleMapsRequest::newTimeZoneRequest(
            new TimeZoneLocation('39.6034810', '-119.6822510'),
            self::getDateTimeFromTimestamp(1331161200)
        );

        $response = $client->sendTimeZoneRequest($request);

        self::assertSame('OK', $response->getStatus());
        self::assertNull($response->getErrorMessage());
    }
}
