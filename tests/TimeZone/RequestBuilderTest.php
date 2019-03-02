<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests;

use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Language;
use GoogleMapsClient\TimeZone\TimeZoneLocation;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    public function testTimeZoneRequestBuilding(): void
    {
        $request = GoogleMapsRequest::newTimeZoneRequest(
            new TimeZoneLocation('39.6034810', '-119.6822510'),
            1331161200
        )->withLanguage(Language::CZECH());

        $generatedUri = urldecode($request->getRequest()->getUri()->__toString());
        $expectedUri = '/location=39.6034810,-119.6822510&timestamp=1331161200&language=cs';

        self::assertSame($expectedUri, $generatedUri);
    }
}
