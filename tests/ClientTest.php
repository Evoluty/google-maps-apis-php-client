<?php

use GoogleMapClient\GoogleMapClient;
use GoogleMapClient\GoogleMapRequest;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    public function testClientUsage()
    {
        $googleClient = new GoogleMapClient('api-key');

        $request = GoogleMapRequest::newTimezoneRequest()
            ->with()
            ->with();

        $timezoneResponse = $googleClient->sendTimezoneRequest($request);
    }
}
