<?php

namespace GoogleMapsClient\Tests;

use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Language;
use GoogleMapsClient\TimezoneApi\TimezoneLocation;

class RequestBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testTimezoneRequestBuilding(): void
    {
        $request = GoogleMapsRequest::newTimezoneRequest(
            new TimezoneLocation('39.6034810', '-119.6822510'), 1331161200
        )->withLanguage(Language::CZECH());

        $generatedUri = urldecode($request->getRequest()->getUri()->__toString());
        $expectedUri = '/location=39.6034810,-119.6822510&timestamp=1331161200&language=cs';

        $this->assertSame($expectedUri, $generatedUri);
    }
}
