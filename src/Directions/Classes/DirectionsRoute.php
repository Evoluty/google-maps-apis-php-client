<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

use GoogleMapsClient\Classes\Polyline;

class DirectionsRoute
{
    /** @var DirectionsBound */
    private $bounds;

    /** @var string */
    private $copyrights;

    /** @var DirectionsLeg[] */
    private $legs;

    /** @var Polyline */
    private $overviewPolyline;

    /** @var string */
    private $summary;

    /** @var string[] */
    private $warnings;

    /** @var int[] */
    private $waypointOrder;

    public function __construct(DirectionsBound $bounds, string $copyrights, array $legs, Polyline $overviewPolyline, string $summary, array $warnings, array $waypointOrder)
    {
        $this->bounds = $bounds;
        $this->copyrights = $copyrights;
        $this->legs = $legs;
        $this->overviewPolyline = $overviewPolyline;
        $this->summary = $summary;
        $this->warnings = $warnings;
        $this->waypointOrder = $waypointOrder;
    }

    public static function factory(\stdClass $stdRoute): self
    {
        return new self(
            DirectionsBound::factory($stdRoute->bounds),
            $stdRoute->copyrights,
            array_map(function (\stdClass $leg) { return DirectionsLeg::factory($leg); }, $stdRoute->legs),
            Polyline::factory($stdRoute->overview_polyline),
            $stdRoute->summary,
            $stdRoute->warnings,
            array_map('intval', $stdRoute->waypoint_order)
        );
    }

    public function getBounds(): DirectionsBound
    {
        return $this->bounds;
    }

    public function getCopyrights(): string
    {
        return $this->copyrights;
    }

    /** @return DirectionsLeg[] */
    public function getLegs(): array
    {
        return $this->legs;
    }

    public function getOverviewPolyline(): Polyline
    {
        return $this->overviewPolyline;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    /** @return string[] */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /** @return int[] */
    public function getWaypointOrder(): array
    {
        return $this->waypointOrder;
    }
}
