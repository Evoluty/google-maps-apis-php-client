<?php

declare(strict_types=1);

namespace GoogleMapsClient\Elevation;

use GoogleMapsClient\Elevation\Classes\ElevationGeolocationLocation;
use GoogleMapsClient\Elevation\Classes\ElevationLocation;
use GoogleMapsClient\Elevation\Classes\ElevationPolylineLocation;
use GoogleMapsClient\GoogleMapsRequest;

class ElevationPositionalRequest extends GoogleMapsRequest
{
    /** @var ElevationLocation[] */
    private $locations = [];

    public function withGeolocationLocation(string $latitude, string $longitude): self
    {
        $location = new ElevationGeolocationLocation($latitude, $longitude);
        return $this->withLocation($location);
    }

    public function withPolylineLocation(string $polyline): self
    {
        $location = new ElevationPolylineLocation($polyline);
        return $this->withLocation($location);
    }

    private function withLocation(ElevationLocation $location): self
    {
        $this->locations[] = $location;
        return $this;
    }

    protected function getQueryString(): string
    {
        if (empty($this->locations)) {
            throw new \UnexpectedValueException('Elevation request need at least one location');
        }

        return http_build_query([
            'locations' => join('|', array_map('strval', $this->locations)),
        ]);
    }
}
