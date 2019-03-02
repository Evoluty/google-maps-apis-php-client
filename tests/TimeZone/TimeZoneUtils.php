<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\TimeZone;

trait TimeZoneUtils
{
    public static function getDateTimeFromTimestamp(int $timestamp): \DateTime
    {
        $return = new \DateTime();
        $return->setTimestamp($timestamp);
        return $return;
    }
}