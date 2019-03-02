<?php

declare(strict_types=1);

namespace GoogleMapsClient\TimezoneApi;

use GoogleMapsClient\GoogleMapsResponse;

class TimezoneResponse extends GoogleMapsResponse
{
    /** @var int */
    private $dstOffset;

    /** @var int */
    private $rawOffset;

    /** @var string */
    private $timeZoneId;

    /** @var string */
    private $timeZoneName;

    public function __construct(int $dstOffset, int $rawOffset, string $timeZoneId, string $timeZoneName, string $status, ?string $errorMessage = null)
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
            isset($apiResponse->dstOffset) ? (int)$apiResponse->dstOffset : null,
            isset($apiResponse->rawOffset) ? (int)$apiResponse->rawOffset : null,
            $apiResponse->timeZoneId,
            $apiResponse->timeZoneName,
            $apiResponse->status,
            $apiResponse->errorMessage ?? null
        );
    }

    public function getDstOffset(): int
    {
        return $this->dstOffset;
    }

    public function getRawOffset(): int
    {
        return $this->rawOffset;
    }

    public function getTimeZoneId(): string
    {
        return $this->timeZoneId;
    }

    public function getTimeZoneName(): string
    {
        return $this->timeZoneName;
    }
}
