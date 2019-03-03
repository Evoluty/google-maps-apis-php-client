<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions\Classes;

abstract class DirectionsWaypoint
{
    /** @var bool */
    private $via;

    public function __construct(bool $via = false)
    {
        $this->via = $via;
    }

    protected abstract function getValue(): string;

    public function __toString(): string
    {
        $isVia = '';
        if ($this->via) {
            $isVia .= 'via:';
        }

        return $isVia . $this->getValue();
    }
}
