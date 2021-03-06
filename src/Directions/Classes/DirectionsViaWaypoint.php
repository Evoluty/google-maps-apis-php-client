<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

use GoogleMapsClient\Classes\Geolocation;

class DirectionsViaWaypoint
{
    /** @var Geolocation */
    private $location;

    /** @var int */
    private $stepIndex;

    /** @var string */
    private $stepInterpolation;

    public function __construct(Geolocation $location, int $stepIndex, string $stepInterpolation)
    {
        $this->location = $location;
        $this->stepIndex = $stepIndex;
        $this->stepInterpolation = $stepInterpolation;
    }

    public static function factory(\stdClass $stdViaWaypoint): self
    {
        return new self(
            Geolocation::factory($stdViaWaypoint->location),
            intval($stdViaWaypoint->step_index),
            strval($stdViaWaypoint->step_interpolation)
        );
    }

    public function getLocation(): Geolocation
    {
        return $this->location;
    }

    public function getStepIndex(): int
    {
        return $this->stepIndex;
    }

    public function getStepInterpolation(): string
    {
        return $this->stepInterpolation;
    }
}
