<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

class DirectionsPlaceNameWaypoint extends DirectionsWaypoint
{
    /** @var string */
    protected $placeName;

    public function __construct(string $placeName, bool $isVia = false)
    {
        parent::__construct($isVia);
        $this->placeName = $placeName;
    }

    public function getValue(): string
    {
        return $this->placeName;
    }
}
