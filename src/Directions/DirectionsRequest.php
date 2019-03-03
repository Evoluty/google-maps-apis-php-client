<?php

declare(strict_types=1);

namespace GoogleMapsClient\Directions;

use GoogleMapsClient\Classes\AvoidableRoute;
use GoogleMapsClient\Classes\TrafficModel;
use GoogleMapsClient\Classes\TransitMode;
use GoogleMapsClient\Classes\TransitRoutingPreference;
use GoogleMapsClient\Classes\TravelMode;
use GoogleMapsClient\Directions\Classes\DirectionsGeolocationWaypoint;
use GoogleMapsClient\Directions\Classes\DirectionsPlaceIdWaypoint;
use GoogleMapsClient\Directions\Classes\DirectionsPlaceNameWaypoint;
use GoogleMapsClient\Directions\Classes\DirectionsPolylineWaypoint;
use GoogleMapsClient\Directions\Classes\DirectionsWaypoint;
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

    /** @var DirectionsWaypoint[] */
    private $waypoints = [];

    /** @var bool */
    private $optimizedWaypoints = false;

    /** @var bool|null */
    private $alternatives = null;

    /** @var AvoidableRoute[] */
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

    public function withGeolocationWaypoint(string $latitude, string $longitude, bool $isVia = false): self
    {
        $waypoint = new DirectionsGeolocationWaypoint($latitude, $longitude, $isVia);
        return $this->withWaypoint($waypoint);
    }

    public function withPlaceIdWaypoint(string $placeId, bool $isVia = false): self
    {
        $waypoint = new DirectionsPlaceIdWaypoint($placeId, $isVia);
        return $this->withWaypoint($waypoint);
    }

    public function withPolylineWaypoint(string $polyline, bool $isVia = false): self
    {
        $waypoint = new DirectionsPolylineWaypoint($polyline, $isVia);
        return $this->withWaypoint($waypoint);
    }

    public function withPlaceNameWaypoint(string $placeName, bool $isVia = false): self
    {
        $waypoint = new DirectionsPlaceNameWaypoint($placeName, $isVia);
        return $this->withWaypoint($waypoint);
    }

    private function withWaypoint(DirectionsWaypoint $waypoint): self
    {
        $this->waypoints[] = $waypoint;
        return $this;
    }

    public function withOptimizedWaypoints(): self
    {
        $this->optimizedWaypoints = true;
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
        // @todo: find possible values to replace by an enum
        $this->region = $region;
        return $this;
    }

    public function withArrivalTime(int $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;
        return $this;
    }

    public function withDepartureTime(int $departureTime): self
    {
        $this->departureTime = $departureTime;
        return $this;
    }

    public function withTrafficModel(TrafficModel $trafficModel): self
    {
        $this->trafficModel = $trafficModel;
        return $this;
    }

    public function withTransitMode(TransitMode $transitMode): self
    {
        $this->transitMode[] = $transitMode;
        return $this;
    }

    public function withTransitRoutingPreference(TransitRoutingPreference $preference): self
    {
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
            $wayPoints = '';
            if ($this->optimizedWaypoints) {
                $wayPoints .= 'optimize:true|';
            }

            $wayPoints .= join('|', array_map('strval', $this->waypoints));

            $args['waypoints'] = $wayPoints;
        }

        if (!empty($this->alternatives)) {
            $args['alternatives'] = $this->alternatives ? 'true' : 'false';
        }

        if (!empty($this->avoid)) {
            $args['avoid'] = join('|', array_map(function (AvoidableRoute $e) { return $e->getValue(); }, $this->avoid));
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
            if (!empty($this->departureTime)) {
                throw new \UnexpectedValueException('Both arrival time and departure time cannot be specified for the Directions API');
            }
            $args['arrival_time'] = $this->arrivalTime;
        }

        if (!empty($this->departureTime)) {
            $args['departure_time'] = $this->departureTime;
        }

        if (!empty($this->trafficModel)) {
            if (!TravelMode::DRIVING()->equals($this->mode)) {
                throw new \UnexpectedValueException('The traffic_model can only be specified if the mode is set to driving');
            } else if (empty($this->departureTime)) {
                throw new \UnexpectedValueException('The traffic_model can only be specified if a departure time is set');
            }
            $args['traffic_model'] = $this->trafficModel->getValue();
        }

        if (!empty($this->transitMode)) {
            if (!TravelMode::TRANSIT()->equals($this->mode)) {
                throw new \UnexpectedValueException('The transit_mode can only be specified if the mode is set to transit');
            }
            $args['transit_mode'] = join('|', array_map(function (TransitMode $e) { return $e->getValue(); }, $this->transitMode));
        }

        if (!empty($this->transitRoutingPreference)) {
            if (!TravelMode::TRANSIT()->equals($this->mode)) {
                throw new \UnexpectedValueException('The transit_routing_preference can only be specified if the mode is set to transit');
            }
            $args['transit_routing_preference'] = $this->transitRoutingPreference->getValue();
        }

        return http_build_query($args);
    }
}
