<?php

declare(strict_types=1);

namespace GoogleMapsClient;

use GoogleMapsClient\TimezoneApi\TimezoneLocation;
use GoogleMapsClient\TimezoneApi\TimezoneRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

abstract class GoogleMapsRequest
{
    /** @var RequestFactoryInterface */
    private $requestFactory;

    public function __construct(RequestFactoryInterface $requestFactory = null)
    {
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
    }

    public function getRequest(): RequestInterface
    {
        return $this->requestFactory->createRequest('GET', $this->getQueryString());
    }

    protected abstract function getQueryString(): string;

    public static function newTimezoneRequest(TimezoneLocation $location, int $timestamp, RequestFactoryInterface $uriFactory = null): TimezoneRequest
    {
        return new TimezoneRequest($location, $timestamp, $uriFactory);
    }
}
