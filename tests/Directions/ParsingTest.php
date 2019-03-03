<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Directions;

use GoogleMapsClient\Directions\DirectionsResponse;
use PHPUnit\Framework\TestCase;

class ParsingTest extends TestCase
{
    public function testTimeZoneResponseParsing(): void
    {
        $apiResponse = require __DIR__ . '/DirectionApiResult.php';

        $timeZoneResponse = DirectionsResponse::factory($apiResponse);

        // Response metadata
        self::assertSame('OK', $timeZoneResponse->getStatus());
        self::assertNull($timeZoneResponse->getErrorMessage());

        // Response data

    }
}
