<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Timezone;

use GoogleMapsClient\Classes\Geolocation;
use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Classes\Language;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    public function testTimeZoneRequestBuilding(): void
    {
        $request = GoogleMapsRequest::newTimeZoneRequest(
            new Geolocation('39.6034810', '-119.6822510'),
            1331161200
        )->withLanguage(Language::CZECH());

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/location=39.6034810,-119.6822510&timestamp=1331161200&language=cs';

        self::assertSame($expectedUri, $generatedUri);
    }
}
