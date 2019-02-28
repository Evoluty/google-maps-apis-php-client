<?php

namespace GoogleMapClient;

use Psr\Http\Message\RequestFactoryInterface;

class TimezoneRequest extends GoogleMapRequest
{


    public function __construct(RequestFactoryInterface $requestFactory = null)
    {
        parent::__construct($requestFactory);
    }

    protected function getQueryString(): string
    {
        return http_build_query([

        ]);
    }
}
