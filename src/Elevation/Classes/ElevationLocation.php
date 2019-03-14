<?php

declare(strict_types=1);

namespace GoogleMapsClient\Elevation\Classes;

abstract class ElevationLocation
{
    protected abstract function getValue(): string;

    public function __toString(): string
    {
        return $this->getValue();
    }
}
