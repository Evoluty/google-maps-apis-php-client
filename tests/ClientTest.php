<?php

use GoogleMapClient\GoogleMapClient;
use GoogleMapClient\GoogleMapRequest;
use GoogleMapClient\TimezoneApi\Language;
use GoogleMapClient\TimezoneApi\TimezoneLocation;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    public function testClientUsage()
    {
        $googleClient = new GoogleMapClient('api-key');

        $request = GoogleMapRequest::newTimezoneRequest(
            new TimezoneLocation('39.6034810', '-119.6822510'), 1331161200
        )->withLanguage(Language::CZECH());

        $timezoneResponse = $googleClient->sendTimezoneRequest($request);

        echo $timezoneResponse->getStatus() . PHP_EOL;
        echo $timezoneResponse->getErrorMessage() . PHP_EOL;
        echo $timezoneResponse->getDstOffset() . PHP_EOL;
        echo $timezoneResponse->getRawOffset() . PHP_EOL;
        echo $timezoneResponse->getTimeZoneId() . PHP_EOL;
        echo $timezoneResponse->getTimeZoneName() . PHP_EOL;
    }
}
