<?php

declare(strict_types=1);

namespace GoogleMapsClient\Errors;

class ApiError
{
    /** @var int */
    private $code;

    /** @var string */
    private $message;

    /** @var string */
    private $status;

    public function __construct(int $code, string $message, string $status)
    {
        $this->code = $code;
        $this->message = $message;
        $this->status = $status;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}