<?php

declare(strict_types=1);

namespace GoogleMapsClient;

use GoogleMapsClient\TimeZone\TimeZoneLocation;
use GoogleMapsClient\TimeZone\TimeZoneRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

abstract class GoogleMapsRequest
{
    /** @var RequestFactoryInterface */
    private $requestFactory;

    public function __construct(?RequestFactoryInterface $requestFactory = null)
    {
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
    }

    public function getRequest(): RequestInterface
    {
        return $this->requestFactory->createRequest('GET', $this->getQueryString());
    }

    protected abstract function getQueryString(): string;

    public static function newTimeZoneRequest(TimeZoneLocation $location, int $timestamp, ?RequestFactoryInterface $uriFactory = null): TimeZoneRequest
    {
        return new TimeZoneRequest($location, $timestamp, $uriFactory);
    }
}
