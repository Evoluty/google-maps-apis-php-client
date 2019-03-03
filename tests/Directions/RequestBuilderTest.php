<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Directions;

use GoogleMapsClient\Classes\AvoidableRoute;
use GoogleMapsClient\Classes\TravelMode;
use GoogleMapsClient\GoogleMapsRequest;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    public function testDirectionsBuilderAvoidAndMode(): void
    {
        $request = GoogleMapsRequest::newDirectionsRequest(
            'Toronto', 'Montreal'
        )->withAvoid(AvoidableRoute::HIGHWAYS())
        ->withMode(TravelMode::BICYCLING());

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/origin=Toronto&destination=Montreal&mode=bicycling&avoid=highways';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testDirectionsBuilder(): void
    {
        $request = GoogleMapsRequest::newDirectionsRequest(
            'Brooklyn', 'Queens'
        )->withDepartureTime(1343641500)
        ->withMode(TravelMode::TRANSIT());

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/origin=Brooklyn&destination=Queens&mode=transit&departure_time=1343641500';

        self::assertSame($expectedUri, $generatedUri);
    }
}
