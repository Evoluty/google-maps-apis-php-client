<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Timezone;

use GoogleMapsClient\TimeZone\TimeZoneResponse;
use PHPUnit\Framework\TestCase;

class ParsingTest extends TestCase
{
    private static function getTimeZoneApiResult(): \stdClass
    {
        return (object)[
            'dstOffset' => 0,
            'rawOffset' => -28800,
            'status' => 'OK',
            'timeZoneId' => 'America/Los_Angeles',
            'timeZoneName' => 'Pacific Standard Time',
        ];
    }

    public function testTimeZoneResponseParsing(): void
    {
        $timeZoneResponse = TimeZoneResponse::factory(self::getTimeZoneApiResult());

        // Response metadata
        self::assertSame('OK', $timeZoneResponse->getStatus());
        self::assertNull($timeZoneResponse->getErrorMessage());
        self::assertNull($timeZoneResponse->getError());

        // Response data
        self::assertSame(0, $timeZoneResponse->getDstOffset());
        self::assertSame(-28800, $timeZoneResponse->getRawOffset());
        self::assertSame('America/Los_Angeles', $timeZoneResponse->getTimeZoneId());
        self::assertSame('Pacific Standard Time', $timeZoneResponse->getTimeZoneName());
        $this->assertEquals(new \DateTimeZone('America/Los_Angeles'), $timeZoneResponse->getTimeZone());
    }
}
