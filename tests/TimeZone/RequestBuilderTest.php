<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Timezone;

use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Language;
use GoogleMapsClient\TimeZone\TimeZoneLocation;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    use TimeZoneUtils;

    public function testTimeZoneRequestBuilding(): void
    {
        $request = GoogleMapsRequest::newTimeZoneRequest(
            new TimeZoneLocation('39.6034810', '-119.6822510'),
            self::getDateTimeFromTimestamp(1331161200)
        )->withLanguage(Language::CZECH());

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = 'location=39.6034810,-119.6822510&timestamp=1331161200&language=cs';

        self::assertSame($expectedUri, $generatedUri);
    }
}
