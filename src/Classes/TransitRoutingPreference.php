<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

use MyCLabs\Enum\Enum;

/**
 * @method static self LESS_WALKING()
 * @method static self FEWER_TRANSFERS()
 */
final class TransitRoutingPreference extends Enum
{
    const LESS_WALKING = 'less_walking';
    const FEWER_TRANSFERS = 'fewer_transfers';
}
