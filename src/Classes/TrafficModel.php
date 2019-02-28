<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

use MyCLabs\Enum\Enum;

/**
 * @method static self BEST_GUESS()
 * @method static self PESSIMISTIC()
 * @method static self OPTIMISTIC()
 */
final class TrafficModel extends Enum
{
    const BEST_GUESS = 'best_guess';
    const PESSIMISTIC = 'pessimistic';
    const OPTIMISTIC = 'optimistic';
}
