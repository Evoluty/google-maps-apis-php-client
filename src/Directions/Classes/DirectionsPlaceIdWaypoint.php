<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

class DirectionsPlaceIdWaypoint extends DirectionsWaypoint
{
    /** @var string */
    private $placeId;

    public function __construct(string $placeId, bool $isVia = false)
    {
        parent::__construct($isVia);
        $this->placeId = $placeId;
    }

    public function getValue(): string
    {
        return 'place_id:' . $this->placeId;
    }
}
