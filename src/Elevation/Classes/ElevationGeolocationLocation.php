<?php

declare(strict_types=1);

namespace GoogleMapsClient\Elevation\Classes;

use GoogleMapsClient\Classes\Geolocation;

class ElevationGeolocationLocation extends ElevationLocation
{
    /** @var Geolocation */
    protected $geoLocation;

    public function __construct(string $latitude, string $longitude, bool $isVia = false)
    {
        $this->geoLocation = new Geolocation($latitude, $longitude);
    }

    public function getValue(): string
    {
        return $this->geoLocation->__toString();
    }
}
