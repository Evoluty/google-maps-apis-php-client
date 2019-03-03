<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

use GoogleMapsClient\Classes\Geolocation;

class DirectionsBound
{
    /** @var Geolocation */
    private $northeast;

    /** @var Geolocation */
    private $southwest;

    public function __construct(Geolocation $northeast, Geolocation $southwest)
    {
        $this->northeast = $northeast;
        $this->southwest = $southwest;
    }

    public static function factory(\stdClass $stdBounds): self
    {
        return new self(
            Geolocation::factory($stdBounds->northeast),
            Geolocation::factory($stdBounds->southwest)
        );
    }

    public function getNortheast(): Geolocation
    {
        return $this->northeast;
    }

    public function getSouthwest(): Geolocation
    {
        return $this->southwest;
    }
}
