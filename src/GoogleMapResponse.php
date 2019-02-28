<?php

namespace GoogleMapClient;

abstract class GoogleMapResponse
{
    /** @var string */
    private $status;

    /** @var string|null */
    private $errorMessage;

    public function __construct(string $status, ?string $errorMessage)
    {
        $this->status = $status;
        $this->errorMessage = $errorMessage;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
