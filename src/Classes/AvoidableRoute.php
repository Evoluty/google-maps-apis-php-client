<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

use MyCLabs\Enum\Enum;

/**
 * @method static self TOLLS()
 * @method static self HIGHWAYS()
 * @method static self FERRIES()
 * @method static self INDOOR()
 */
final class AvoidableRoute extends Enum
{
    const TOLLS = 'tolls';
    const HIGHWAYS = 'highways';
    const FERRIES = 'ferries';
    const INDOOR = 'indoor';
}
