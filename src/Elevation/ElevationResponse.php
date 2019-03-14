<?php

declare(strict_types=1);

namespace GoogleMapsClient\Elevation;

use GoogleMapsClient\GoogleMapsResponse;

class ElevationResponse extends GoogleMapsResponse
{
    /** @var ElevationResult[] */
    private $results;

    public function __construct(string $status, ?string $errorMessage, array $results)
    {
        parent::__construct($status, $errorMessage);
        $this->results = $results;
    }

    public static function factory(\stdClass $apiResponse): self
    {
        return new self(
            $apiResponse->status,
            $apiResponse->errorMessage ?? null,
            array_map(function (\stdClass $result) { return ElevationResult::factory($result); }, $apiResponse->results)
        );
    }

    /** @return ElevationResult[] */
    public function getResults(): array
    {
        return $this->results;
    }
}
