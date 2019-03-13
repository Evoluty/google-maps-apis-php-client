<?php

declare(strict_types=1);

namespace GoogleMapsClient\Errors;

class ApiException extends \Exception
{
    public static function from(string $status, ?string $errorMessage): ?ApiException
    {
        switch ($status) {
            // Classic Geo API error formats
            case 'OK':
                return null;
            case 'INVALID_REQUEST':
                return new InvalidRequestException($errorMessage);
            case 'MAX_ELEMENTS_EXCEEDED':
                return new MaxElementsExceededException($errorMessage);
            case 'NOT_FOUND':
                return new NotFoundException($errorMessage);
            case 'OVER_QUERY_LIMIT':
                if (strcasecmp($errorMessage, 'You have exceeded your daily request quota for this API.') === 0) {
                    return new OverDailyLimitException($errorMessage);
                }
                return new OverQueryLimitException($errorMessage);
            case 'REQUEST_DENIED':
                return new RequestDeniedException($errorMessage);
            case 'UNKNOWN_ERROR':
                return new UnknownErrorException($errorMessage);
            case 'ZERO_RESULTS':
                return new ZeroResultsException($errorMessage);

            // New-style Geo API error formats
            case 'ACCESS_NOT_CONFIGURED':
                return new AccessNotConfiguredException($errorMessage);
            case 'INVALID_ARGUMENT':
                return new InvalidRequestException($errorMessage);
            case 'RESOURCE_EXHAUSTED':
                return new OverQueryLimitException($errorMessage);
            case 'PERMISSION_DENIED':
                return new RequestDeniedException($errorMessage);

            // Geolocation Errors
            case 'keyInvalid':
                return new AccessNotConfiguredException($errorMessage);
            case 'dailyLimitExceeded':
                return new OverDailyLimitException($errorMessage);
            case 'userRateLimitExceeded':
                return new OverQueryLimitException($errorMessage);
            case 'notFound':
                return new NotFoundException($errorMessage);
            case 'parseError':
                return new InvalidRequestException($errorMessage);
            case 'invalid':
                return new InvalidRequestException($errorMessage);

            // We've hit an unknown error. This is not a state we should hit,
            // but we don't want to crash a user's application if we introduce a new error.
            default:
                return new UnknownErrorException(
                    'An unexpected error occurred. Status: ' . $status . ', Message: ' . $errorMessage
                );
        }
    }
}
