<?php

use GoogleMapsClient\GoogleMapsClient;
use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\TimezoneApi\Language;
use GoogleMapsClient\TimezoneApi\TimezoneLocation;

class TimezoneApiTest extends \PHPUnit\Framework\TestCase
{
    /** @var string */
    private $key;

    protected function setUp()
    {
        parent::setUp();
        $this->key = require './TestApiKey.php';

    }

    public function testClientUsage()
    {
        $googleClient = new GoogleMapsClient($this->key);

        $request = GoogleMapsRequest::newTimezoneRequest(
            new TimezoneLocation('39.6034810', '-119.6822510'), 1331161200
        )->withLanguage(Language::CZECH());

        $timezoneResponse = $googleClient->sendTimezoneRequest($request);

        // Response metadata
        $this->assertSame('OK', $timezoneResponse->getStatus());
        $this->assertNull($timezoneResponse->getErrorMessage());

        // Response data
        $this->assertSame(0, $timezoneResponse->getDstOffset());
        $this->assertSame(-28800, $timezoneResponse->getRawOffset());
        $this->assertSame('America/Los_Angeles', $timezoneResponse->getTimeZoneId());
        $this->assertSame('Severoamerický pacifický standardní čas', $timezoneResponse->getTimeZoneName());
    }
}
