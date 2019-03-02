<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests;

use GoogleMapsClient\GoogleMapsClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client;

abstract class AbstractClientTest extends TestCase
{
    protected static function getClient(Response $expectedResponse): GoogleMapsClient
    {
        $mock = new MockHandler([$expectedResponse]);

        $handler = HandlerStack::create($mock);
        $guzzleClient = Client::createWithConfig(['handler' => $handler]);

        return new GoogleMapsClient('key', $guzzleClient);
    }
}
