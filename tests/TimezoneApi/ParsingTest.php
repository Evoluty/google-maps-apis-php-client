<?php

namespace GoogleMapsClient\Tests;

use GoogleMapsClient\TimezoneApi\TimezoneResponse;

class ParsingTest extends \PHPUnit\Framework\TestCase
{
    private function getTimezoneApiResult(): \stdClass
    {
        return (object)[
            'dstOffset' => 0,
            'rawOffset' => -28800,
            'status' => 'OK',
            'timeZoneId' => 'America/Los_Angeles',
            'timeZoneName' => 'Pacific Standard Time'
        ];
    }

    public function testTimezoneResponseParsing(): void
    {
        $timezoneResponse = TimezoneResponse::factory($this->getTimezoneApiResult());

        // Response metadata
        $this->assertSame('OK', $timezoneResponse->getStatus());
        $this->assertNull($timezoneResponse->getErrorMessage());

        // Response data
        $this->assertSame(0, $timezoneResponse->getDstOffset());
        $this->assertSame(-28800, $timezoneResponse->getRawOffset());
        $this->assertSame('America/Los_Angeles', $timezoneResponse->getTimeZoneId());
        $this->assertSame('Pacific Standard Time', $timezoneResponse->getTimeZoneName());
    }
}
