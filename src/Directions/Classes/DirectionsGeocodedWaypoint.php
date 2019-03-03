<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

class DirectionsGeocodedWaypoint
{
    /** @var string */
    private $geocoderStatus;

    /** @var string */
    private $placeId;

    /** @todo: use enum */
    /** @var string[] */
    private $types;

    public function __construct(string $geocoderStatus, string $placeId, array $types)
    {
        $this->geocoderStatus = $geocoderStatus;
        $this->placeId = $placeId;
        $this->types = $types;
    }

    public static function factory(\stdClass $stdGeoWaypoint): self
    {
        return new self(
            $stdGeoWaypoint->geocoder_status,
            $stdGeoWaypoint->place_id,
            $stdGeoWaypoint->types
        );
    }

    public function getGeocoderStatus(): string
    {
        return $this->geocoderStatus;
    }

    public function getPlaceId(): string
    {
        return $this->placeId;
    }

    /** @return string[] */
    public function getTypes(): array
    {
        return $this->types;
    }
}
