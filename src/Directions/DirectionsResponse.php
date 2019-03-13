<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions;

use GoogleMapsClient\Directions\Classes\DirectionsGeocodedWaypoint;
use GoogleMapsClient\Directions\Classes\DirectionsRoute;
use GoogleMapsClient\GoogleMapsResponse;

class DirectionsResponse extends GoogleMapsResponse
{
    /** @var DirectionsGeocodedWaypoint[] */
    private $geocodedWaypoints;

    /** @var DirectionsRoute[] */
    private $routes;

    public function __construct(string $status, ?string $errorMessage, ?array $geocodedWaypoints, ?array $routes)
    {
        parent::__construct($status, $errorMessage);
        $this->geocodedWaypoints = $geocodedWaypoints;
        $this->routes = $routes;
    }

    public static function factory(\stdClass $apiResponse): self
    {
        return new self(
            $apiResponse->status,
            $apiResponse->errorMessage ?? null,
            isset($apiResponse->geocoded_waypoints) ? array_map(function (\stdClass $geoWaypoint) {
                return DirectionsGeocodedWaypoint::factory($geoWaypoint);
            }, $apiResponse->geocoded_waypoints) : null,
            isset($apiResponse->routes) ? array_map(function (\stdClass $route) {
                return DirectionsRoute::factory($route);
            }, $apiResponse->routes) : null
        );
    }

    /** @return DirectionsGeocodedWaypoint[] */
    public function getGeocodedWaypoints(): array
    {
        return $this->geocodedWaypoints;
    }

    /** @return DirectionsRoute[] */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function successful(): bool
    {
        return $this->getStatus() === 'OK' || $this->getStatus() === 'ZERO_RESULTS';
    }
}
