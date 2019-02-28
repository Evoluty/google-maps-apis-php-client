<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

use MyCLabs\Enum\Enum;

/**
 * @method static self DRIVING()
 * @method static self WALKING()
 * @method static self BICYCLING()
 * @method static self TRANSIT()
 */
final class TravelMode extends Enum
{
    const DRIVING = 'driving';
    const WALKING = 'walking';
    const BICYCLING = 'bicycling';
    const TRANSIT = 'transit';
}
