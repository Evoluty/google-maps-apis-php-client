<?php

declare(strict_types=1);

namespace GoogleMapsClient\Elevation\Classes;

use GoogleMapsClient\Classes\Polyline;

class ElevationPolylineLocation extends ElevationLocation
{
    /** @var Polyline */
    protected $polyline;

    public function __construct(string $polyline)
    {
        $this->polyline = $polyline;
    }

    public function getValue(): string
    {
        return 'enc:' . $this->polyline;
    }
}
