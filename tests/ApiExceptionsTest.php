<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests;

use GoogleMapsClient\Errors\AccessNotConfiguredException;
use GoogleMapsClient\Errors\ApiException;
use GoogleMapsClient\Errors\InvalidRequestException;
use GoogleMapsClient\Errors\MaxElementsExceededException;
use GoogleMapsClient\Errors\NotFoundException;
use GoogleMapsClient\Errors\OverDailyLimitException;
use GoogleMapsClient\Errors\OverQueryLimitException;
use GoogleMapsClient\Errors\RequestDeniedException;
use GoogleMapsClient\Errors\UnknownErrorException;
use GoogleMapsClient\Errors\ZeroResultsException;
use PHPUnit\Framework\TestCase;

class ApiExceptionsTest extends TestCase
{
    /** @dataProvider provider */
    public function testException(?string $exceptionName, string $status, ?string $errorMessage): void
    {
        $response = ApiException::from($status, $errorMessage);

        if ($exceptionName === null) {
            self::assertSame(null, $response);
        } else {
            self::assertSame(get_class($response), $exceptionName);
        }
    }

    public function provider(): array
    {
        return [
            [null, 'OK', null],
            [InvalidRequestException::class, 'INVALID_REQUEST', 'test error'],
            [MaxElementsExceededException::class, 'MAX_ELEMENTS_EXCEEDED', 'test error'],
            [NotFoundException::class, 'NOT_FOUND', 'test error'],
            [OverQueryLimitException::class, 'OVER_QUERY_LIMIT', 'test error'],
            [OverDailyLimitException::class, 'OVER_QUERY_LIMIT', 'You have exceeded your daily request quota for this API.'],
            [RequestDeniedException::class, 'REQUEST_DENIED', 'test error'],
            [UnknownErrorException::class, 'UNKNOWN_ERROR', 'test error'],
            [ZeroResultsException::class, 'ZERO_RESULTS', 'test error'],
            [AccessNotConfiguredException::class, 'ACCESS_NOT_CONFIGURED', 'test error'],
            [InvalidRequestException::class, 'INVALID_ARGUMENT', 'test error'],
            [OverQueryLimitException::class, 'RESOURCE_EXHAUSTED', 'test error'],
            [RequestDeniedException::class, 'PERMISSION_DENIED', 'test error'],
            [AccessNotConfiguredException::class, 'keyInvalid', 'test error'],
            [OverDailyLimitException::class, 'dailyLimitExceeded', 'test error'],
            [OverQueryLimitException::class, 'userRateLimitExceeded', 'test error'],
            [NotFoundException::class, 'notFound', 'test error'],
            [InvalidRequestException::class, 'parseError', 'test error'],
            [InvalidRequestException::class, 'invalid', 'test error'],
            [OverQueryLimitException::class, 'userRateLimitExceeded', 'test error'],
            [UnknownErrorException::class, 'unknownerror', 'test error'],
        ];
    }
}
