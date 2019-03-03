<?php

namespace GoogleMapsClient\Elevation;

use GoogleMapsClient\Classes\Geolocation;

class ElevationResult
{
    /** @var string */
    private $elevation;

    /** @var Geolocation */
    private $location;

    /** @var string */
    private $resolution;

    public function __construct(string $elevation, Geolocation $location, string $resolution)
    {
        $this->elevation = $elevation;
        $this->location = $location;
        $this->resolution = $resolution;
    }

    public static function factory(\stdClass $stdElevationResult): self
    {
        return new self(
            strval($stdElevationResult->elevation),
            Geolocation::factory($stdElevationResult->location),
            strval($stdElevationResult->resolution)
        );
    }

    public function getElevation(): string
    {
        return $this->elevation;
    }

    public function getLocation(): Geolocation
    {
        return $this->location;
    }

    public function getResolution(): string
    {
        return $this->resolution;
    }
}
