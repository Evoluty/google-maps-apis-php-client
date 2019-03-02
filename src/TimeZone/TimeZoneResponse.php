<?php

declare(strict_types=1);

namespace GoogleMapsClient\TimeZone;

use GoogleMapsClient\GoogleMapsResponse;

class TimeZoneResponse extends GoogleMapsResponse
{
    /** @var int */
    private $requestedTimestamp;

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
        int $requestedTimestamp,
        ?int $dstOffset,
        ?int $rawOffset,
        ?string $timeZoneId,
        ?string $timeZoneName)
    {
        parent::__construct($status, $errorMessage);
        $this->requestedTimestamp = $requestedTimestamp;
        $this->dstOffset = $dstOffset;
        $this->rawOffset = $rawOffset;
        $this->timeZoneId = $timeZoneId;
        $this->timeZoneName = $timeZoneName;
    }

    public static function factory(int $requestedTimestamp, \stdClass $apiResponse): self
    {
        return new self(
            $apiResponse->status,
            $apiResponse->errorMessage ?? null,
            $requestedTimestamp,
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

    public function getResult(): ?\DateTimeZone
    {
        if ($this->timeZoneId === null) {
            return null;
        }
        return new \DateTimeZone($this->timeZoneId);
    }

    public function successful(): bool
    {
        return $this->getStatus() === 'OK';
    }

    public function getLocalDate(): ?\DateTime
    {
        $timeZone = $this->getResult();
        if ($timeZone === null) {
            return null;
        }

        $return = new \DateTime();
        $return->setTimestamp($this->requestedTimestamp);
        $return->setTimezone($timeZone);

        return $return;
    }
}
