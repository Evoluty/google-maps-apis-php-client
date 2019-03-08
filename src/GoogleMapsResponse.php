<?php

declare(strict_types=1);

namespace GoogleMapsClient;

use GoogleMapsClient\Errors\ApiException;

abstract class GoogleMapsResponse
{
    /** @var string */
    private $status;

    /** @var string|null */
    private $errorMessage;

    public function __construct(string $status, ?string $errorMessage)
    {
        $this->status = $status;
        $this->errorMessage = $errorMessage;
        self::assertSuccessful($this);
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public abstract function successful(): bool;

    public function getError(): ?ApiException
    {
        if ($this->successful()) {
            return null;
        }
        return ApiException::from($this->status, $this->errorMessage);
    }

    /**
     * @param GoogleMapsResponse $response
     * @throws Errors\ApiException
     */
    private static function assertSuccessful(GoogleMapsResponse $response): void
    {
        if (!$response->successful()) {
            throw $response->getError();
        }
    }
}
