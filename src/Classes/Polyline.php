<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

class Polyline
{
    /** @var string */
    private $points;

    public function __construct(string $points)
    {
        $this->points = $points;
    }

    public static function factory(\stdClass $stdPolyline): self
    {
        return new self(
            $stdPolyline->points
        );
    }

    public function getPoints(): string
    {
        return $this->points;
    }
}
