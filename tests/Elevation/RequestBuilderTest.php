<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Elevation;

use GoogleMapsClient\GoogleMapsRequest;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    public function testElevationLocationBuilding(): void
    {
        $request = GoogleMapsRequest::newElevationRequest()
            ->withGeolocationLocation('39.6034810', '-119.6822510');

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/locations=39.6034810,-119.6822510';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testElevationPathBuilding(): void
    {
        $request = GoogleMapsRequest::newElevationRequest()
            ->withGeolocationLocation('39.6034810', '-119.6822510')
            ->asPathRequest(3);

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/samples=3&path=39.6034810,-119.6822510';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testElevationEmptyBuilding(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Elevation request need at least one location');

        $request = GoogleMapsRequest::newElevationRequest();
        $request->getRequest();
    }
}
