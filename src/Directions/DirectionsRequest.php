<?php

namespace GoogleMapsClient\Directions;

use GoogleMapsClient\Classes\AvoidableRoute;
use GoogleMapsClient\Classes\TrafficModel;
use GoogleMapsClient\Classes\TransitMode;
use GoogleMapsClient\Classes\TransitRoutingPreference;
use GoogleMapsClient\Classes\TravelMode;
use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Classes\Language;
use GoogleMapsClient\Classes\UnitSystem;
use Psr\Http\Message\RequestFactoryInterface;

class DirectionsRequest extends GoogleMapsRequest
{
    /** @var string */
    private $origin;

    /** @var string */
    private $destination;

    /** @var TravelMode|null */
    private $mode = null;

    /** @var string[] */
    private $waypoints = [];

    /** @var bool|null */
    private $alternatives = null;

    /** @var string[] */
    private $avoid = [];

    /** @var Language|null */
    private $language = null;

    /** @var UnitSystem|null */
    private $unit = null;

    /** @var string|null */
    private $region = null;

    /** @var int|null */
    private $arrivalTime = null;

    /** @var int|null */
    private $departureTime = null;

    /** @var TrafficModel|null */
    private $trafficModel = null;

    /** @var TransitMode[] */
    private $transitMode = [];

    /** @var TransitRoutingPreference|null */
    private $transitRoutingPreference = null;

    public function __construct(string $origin, string $destination, RequestFactoryInterface $requestFactory = null)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        parent::__construct($requestFactory);
    }

    public function withMode(TravelMode $mode): self
    {
        $this->mode = $mode;
        return $this;
    }

    public function withWaypoint(string $waypoint): self
    {
        // &todo: add optimise:true parameter to optimise waypoints order
        // @todo: add "via" endpoints handling to avoid stopover waypoints
        $this->waypoints[] = $waypoint;
        return $this;
    }

    public function withAlternatives(bool $alternatives): self
    {
        $this->alternatives = $alternatives;
        return $this;
    }

    public function withAvoid(AvoidableRoute $route): self
    {
        $this->avoid[] = $route;
        return $this;
    }

    public function withLanguage(Language $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function withUnits(UnitSystem $unitSystem): self
    {
        $this->unit = $unitSystem;
        return $this;
    }

    public function withRegion(string $region): self
    {
        // @todo: why not an Enum for that
        $this->region = $region;
        return $this;
    }

    public function withArrivalTime(int $arrivalTime): self
    {
        // @todo: check with departure time
        $this->arrivalTime = $arrivalTime;
        return $this;
    }

    public function withDepartureTime(int $departureTime): self
    {
        // @todo: check with arrival time and travel mode
        $this->departureTime = $departureTime;
        return $this;
    }

    public function withTrafficModel(TrafficModel $trafficModel): self
    {
        // @todo: check need departure time
        $this->trafficModel = $trafficModel;
        return $this;
    }

    public function withTransitMode(TransitMode $transitMode): self
    {
        // @todo: check that we are in transit mode
        $this->transitMode[] = $transitMode;
        return $this;
    }

    public function withTransitRoutingPreference(TransitRoutingPreference $preference): self
    {
        // @todo: check that we are in transit mode
        $this->transitRoutingPreference = $preference;
        return $this;
    }

    protected function getQueryString(): string
    {
        $args = [
            'origin' => $this->origin,
            'destination' => $this->destination,
        ];

        if (!empty($this->mode)) {
            $args['mode'] = $this->mode->getValue();
        }

        if (!empty($this->waypoints)) {
            $args['waypoints'] = join('|', array_values($this->waypoints));
        }

        if (!empty($this->alternatives)) {
            $args['alternatives'] = $this->alternatives;
        }

        if (!empty($this->avoid)) {
            $args['avoid'] = join('|', array_map(function (AvoidableRoute $e) { return $e->getValue(); }, $this->waypoints));
        }

        if (!empty($this->language)) {
            $args['language'] = $this->language->getValue();
        }

        if (!empty($this->unit)) {
            $args['unit'] = $this->unit->getValue();
        }

        if (!empty($this->region)) {
            $args['region'] = $this->region;
        }

        if (!empty($this->arrivalTime)) {
            $args['arrival_time'] = $this->arrivalTime;
        }

        if (!empty($this->departureTime)) {
            $args['departure_time'] = $this->departureTime;
        }

        if (!empty($this->trafficModel)) {
            $args['traffic_model'] = $this->trafficModel->getValue();
        }

        if (!empty($this->transitMode)) {
            $args['transit_mode'] = join('|', array_map(function (TransitMode $e) { return $e->getValue(); }, $this->transitMode));
        }

        return http_build_query($args);
    }
}
