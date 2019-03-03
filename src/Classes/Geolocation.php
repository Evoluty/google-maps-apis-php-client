<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

class Geolocation
{
    /** @var string */
    private $latitude;

    /** @var string */
    private $longitude;

    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public static function factory(\stdClass $stdGeolocation): self
    {
        return new self(
            strval($stdGeolocation->lat),
            strval($stdGeolocation->lng)
        );
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function __toString(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }
}
