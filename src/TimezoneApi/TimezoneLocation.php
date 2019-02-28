<?php

namespace GoogleMapClient\TimezoneApi;

class TimezoneLocation
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

    public function __toString(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }
}
