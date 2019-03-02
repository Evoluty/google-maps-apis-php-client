<?php

declare(strict_types=1);

namespace GoogleMapsClient\TimeZone;

use GoogleMapsClient\GoogleMapsResponse;

class TimeZoneResponse extends GoogleMapsResponse
{
    /** @var int|null */
    private $dstOffset;

    /** @var int|null */
    private $rawOffset;

    /** @var string|null */
    private $timeZoneId;

    /** @var string|null */
    private $timeZoneName;

    public function __construct(
        string $status,
        ?string $errorMessage,
        ?int $dstOffset,
        ?int $rawOffset,
        ?string $timeZoneId,
        ?string $timeZoneName)
    {
        parent::__construct($status, $errorMessage);
        $this->dstOffset = $dstOffset;
        $this->rawOffset = $rawOffset;
        $this->timeZoneId = $timeZoneId;
        $this->timeZoneName = $timeZoneName;
    }

    public static function factory(\stdClass $apiResponse): self
    {
        return new self(
            $apiResponse->status,
            $apiResponse->errorMessage ?? null,
            isset($apiResponse->dstOffset) ? (int)$apiResponse->dstOffset : null,
            isset($apiResponse->rawOffset) ? (int)$apiResponse->rawOffset : null,
            $apiResponse->timeZoneId ?? null,
            $apiResponse->timeZoneName ?? null
        );
    }

    public function getDstOffset(): ?int
    {
        return $this->dstOffset;
    }

    public function getRawOffset(): ?int
    {
        return $this->rawOffset;
    }

    public function getTimeZoneId(): ?string
    {
        return $this->timeZoneId;
    }

    public function getTimeZoneName(): ?string
    {
        return $this->timeZoneName;
    }
}
