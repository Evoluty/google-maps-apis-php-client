<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests;

use GoogleMapsClient\TimezoneApi\TimezoneResponse;
use PHPUnit\Framework\TestCase;

class ParsingTest extends TestCase
{
    private static function getTimezoneApiResult(): \stdClass
    {
        return (object)[
            'dstOffset' => 0,
            'rawOffset' => -28800,
            'status' => 'OK',
            'timeZoneId' => 'America/Los_Angeles',
            'timeZoneName' => 'Pacific Standard Time',
        ];
    }

    public function testTimezoneResponseParsing(): void
    {
        $timezoneResponse = TimezoneResponse::factory(self::getTimezoneApiResult());

        // Response metadata
        self::assertSame('OK', $timezoneResponse->getStatus());
        self::assertNull($timezoneResponse->getErrorMessage());

        // Response data
        self::assertSame(0, $timezoneResponse->getDstOffset());
        self::assertSame(-28800, $timezoneResponse->getRawOffset());
        self::assertSame('America/Los_Angeles', $timezoneResponse->getTimeZoneId());
        self::assertSame('Pacific Standard Time', $timezoneResponse->getTimeZoneName());
    }
}
