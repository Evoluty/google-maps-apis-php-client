<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

use MyCLabs\Enum\Enum;

/**
 * @method static self METRIC()
 * @method static self IMPERIAL()
 */
final class UnitSystem extends Enum
{
    const METRIC = 'metric';
    const IMPERIAL = 'imperial';
}
