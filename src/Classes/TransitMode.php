<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

use MyCLabs\Enum\Enum;

/**
 * @method static self BUS()
 * @method static self SUBWAY()
 * @method static self TRAIN()
 * @method static self TRAM()
 * @method static self RAIL()
 */
final class TransitMode extends Enum
{
    const BUS = 'bus';
    const SUBWAY = 'subway';
    const TRAIN = 'train';
    const TRAM = 'tram';
    const RAIL = 'rail';
}
