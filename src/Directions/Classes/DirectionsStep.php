<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

use GoogleMapsClient\Classes\Distance;
use GoogleMapsClient\Classes\Duration;
use GoogleMapsClient\Classes\Geolocation;
use GoogleMapsClient\Classes\Polyline;
use GoogleMapsClient\Classes\TravelMode;

class DirectionsStep
{
    /** @var Distance */
    private $distance;

    /** @var Duration */
    private $duration;

    /** @var Geolocation */
    private $endLocation;

    /** @var string */
    private $htmlInstructions;

    /** @var Polyline */
    private $polyline;

    /** @var Geolocation */
    private $startLocation;

    /** @var TravelMode */
    private $travelMode;

    public function __construct(Distance $distance, Duration $duration, Geolocation $endLocation, string $htmlInstructions, Polyline $polyline, Geolocation $startLocation, TravelMode $travelMode)
    {
        $this->distance = $distance;
        $this->duration = $duration;
        $this->endLocation = $endLocation;
        $this->htmlInstructions = $htmlInstructions;
        $this->polyline = $polyline;
        $this->startLocation = $startLocation;
        $this->travelMode = $travelMode;
    }

    public static function factory(\stdClass $stdStep): self
    {
        return new self(
            Distance::factory($stdStep->distance),
            Duration::factory($stdStep->duration),
            Geolocation::factory($stdStep->end_location),
            $stdStep->html_instructions,
            Polyline::factory($stdStep->polyline),
            Geolocation::factory($stdStep->start_location),
            TravelMode::factory($stdStep->travel_mode)
        );
    }

    public function getDistance(): Distance
    {
        return $this->distance;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }

    public function getEndLocation(): Geolocation
    {
        return $this->endLocation;
    }

    public function getHtmlInstructions(): string
    {
        return $this->htmlInstructions;
    }

    public function getPolyline(): Polyline
    {
        return $this->polyline;
    }

    public function getStartLocation(): Geolocation
    {
        return $this->startLocation;
    }

    public function getTravelMode(): TravelMode
    {
        return $this->travelMode;
    }
}
