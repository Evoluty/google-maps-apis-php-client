<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Timezone;

use GoogleMapsClient\Classes\Geolocation;
use GoogleMapsClient\Classes\Language;
use GoogleMapsClient\GoogleMapsRequest;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    use TimeZoneUtils;

    public function testTimeZoneRequestBuilding(): void
    {
        $request = GoogleMapsRequest::newTimeZoneRequest(
            new Geolocation('39.6034810', '-119.6822510')
        )->withDateTime(self::getDateTimeFromTimestamp(1331161200))
        ->withLanguage(Language::CZECH());

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/location=39.6034810,-119.6822510&timestamp=1331161200&language=cs';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testTimeZoneRequestBuildingEmptyDatetime(): void
    {
        $request = GoogleMapsRequest::newTimeZoneRequest(
            new Geolocation('39.6034810', '-119.6822510')
        )->withLanguage(Language::CZECH());

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());

        $date = new \DateTime();
        $expectedUri = '/location=39.6034810,-119.6822510&timestamp=' . $date->getTimestamp() . '&language=cs';

        self::assertSame($expectedUri, $generatedUri);
    }
}
