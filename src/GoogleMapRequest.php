<?php

namespace GoogleMapClient;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

abstract class GoogleMapRequest
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

    public static function newTimezoneRequest(RequestFactoryInterface $uriFactory = null): TimezoneRequest
    {
        return new TimezoneRequest($uriFactory);
    }
}
