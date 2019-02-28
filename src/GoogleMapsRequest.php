<?php

declare(strict_types=1);

namespace GoogleMapsClient;

use GoogleMapsClient\Classes\Geolocation;
use GoogleMapsClient\Directions\DirectionsRequest;
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

    public static function newTimeZoneRequest(Geolocation $location, int $timestamp, ?RequestFactoryInterface $uriFactory = null): TimeZoneRequest
    {
        return new TimeZoneRequest($location, $timestamp, $uriFactory);
    }

    public static function newDirectionsRequest(string $origin, string $destination, RequestFactoryInterface $uriFactory = null): DirectionsRequest
    {
        return new DirectionsRequest($origin, $destination, $uriFactory);
    }
}
