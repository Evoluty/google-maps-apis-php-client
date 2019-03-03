<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

use GoogleMapsClient\Classes\Distance;
use GoogleMapsClient\Classes\Duration;
use GoogleMapsClient\Classes\Geolocation;

class DirectionsLeg
{
    /** @var Distance */
    private $distance;

    /** @var Duration */
    private $duration;

    /** @var Duration|null */
    private $durationInTraffic;

    /** @var string */
    private $endAddress;

    /** @var Geolocation */
    private $endLocation;

    /** @var string */
    private $startAddress;

    /** @var Geolocation */
    private $startLocation;

    /** @var DirectionsStep[] */
    private $steps;

    /** @var string[] */
    private $trafficSpeedEntry;

    /** @var DirectionsViaWaypoint[] */
    private $viaWaypoints;

    public function __construct(Distance $distance, Duration $duration, ?Duration $durationInTraffic, string $endAddress, Geolocation $endLocation, string $startAddress, Geolocation $startLocation, array $steps, array $trafficSpeedEntry, array $viaWaypoints)
    {
        $this->distance = $distance;
        $this->duration = $duration;
        $this->durationInTraffic = $durationInTraffic;
        $this->endAddress = $endAddress;
        $this->endLocation = $endLocation;
        $this->startAddress = $startAddress;
        $this->startLocation = $startLocation;
        $this->steps = $steps;
        $this->trafficSpeedEntry = $trafficSpeedEntry;
        $this->viaWaypoints = $viaWaypoints;
    }

    public static function factory(\stdClass $leg): self
    {
        return new self(
            Distance::factory($leg->distance),
            Duration::factory($leg->duration),
            isset($leg->duration_in_traffic) ? Duration::factory($leg->duration_in_traffic) : null,
            $leg->end_address,
            Geolocation::factory($leg->end_location),
            $leg->start_address,
            Geolocation::factory($leg->start_location),
            array_map(function (\stdClass $step) { return DirectionsStep::factory($step); }, $leg->steps),
            $leg->traffic_speed_entry,
            array_map(function (\stdClass $viaWaypoint) { return DirectionsViaWaypoint::factory($viaWaypoint); }, $leg->via_waypoint)
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

    public function getDurationInTraffic(): ?Duration
    {
        return $this->durationInTraffic;
    }

    public function getEndAddress(): string
    {
        return $this->endAddress;
    }

    public function getEndLocation(): Geolocation
    {
        return $this->endLocation;
    }

    public function getStartAddress(): string
    {
        return $this->startAddress;
    }

    public function getStartLocation(): Geolocation
    {
        return $this->startLocation;
    }

    /** @return DirectionsStep[] */
    public function getSteps(): array
    {
        return $this->steps;
    }

    /** @return string[] */
    public function getTrafficSpeedEntry(): array
    {
        return $this->trafficSpeedEntry;
    }

    /** @return DirectionsViaWaypoint[] */
    public function getViaWaypoints(): array
    {
        return $this->viaWaypoints;
    }
}
