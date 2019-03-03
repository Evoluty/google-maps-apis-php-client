<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

use GoogleMapsClient\Classes\Geolocation;

class DirectionsGeolocationWaypoint extends DirectionsWaypoint
{
    /** @var Geolocation */
    protected $geoLocation;

    public function __construct(string $latitude, string $longitude, bool $isVia = false)
    {
        parent::__construct($isVia);
        $this->geoLocation = new Geolocation($latitude, $longitude);
    }

    public function getValue(): string
    {
        return $this->geoLocation->__toString();
    }
}
