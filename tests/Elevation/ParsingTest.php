<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Elevation;

use GoogleMapsClient\Elevation\ElevationResponse;
use PHPUnit\Framework\TestCase;

class ParsingTest extends TestCase
{
    private static function getElevationApiResult(): \stdClass
    {
        return (object)[
            'results' => [
                (object)[
                    'elevation' => 1608.637939453125,
                    'location' => (object)[
                        'lat' => 39.73915360,
                        'lng' => -104.98470340,
                    ],
                    'resolution' => 4.771975994110107,
                ]
            ],
            'status' => 'OK',
        ];
    }

    public function testElevationResponseParsing(): void
    {
        $timeZoneResponse = ElevationResponse::factory(self::getElevationApiResult());

        // Response metadata
        self::assertSame('OK', $timeZoneResponse->getStatus());
        self::assertNull($timeZoneResponse->getErrorMessage());

        // Response data
        self::assertSame('1608.6379394531', $timeZoneResponse->getResults()[0]->getElevation());
        self::assertSame('39.7391536', $timeZoneResponse->getResults()[0]->getLocation()->getLatitude());
        self::assertSame('-104.9847034', $timeZoneResponse->getResults()[0]->getLocation()->getLongitude());
        self::assertSame('4.7719759941101', $timeZoneResponse->getResults()[0]->getResolution());
    }
}
