<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

class DirectionsPolylineWaypoint extends DirectionsWaypoint
{
    /** @var string */
    protected $polyline;

    public function __construct(string $polyline, bool $isVia = false)
    {
        parent::__construct($isVia);
        $this->polyline = $polyline;
    }

    public function getValue(): string
    {
        return 'enc:' . $this->polyline;
    }
}
