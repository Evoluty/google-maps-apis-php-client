<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Directions;

use GoogleMapsClient\Classes\AvoidableRoute;
use GoogleMapsClient\Classes\Language;
use GoogleMapsClient\Classes\TrafficModel;
use GoogleMapsClient\Classes\TransitMode;
use GoogleMapsClient\Classes\TransitRoutingPreference;
use GoogleMapsClient\Classes\TravelMode;
use GoogleMapsClient\Classes\UnitSystem;
use GoogleMapsClient\GoogleMapsRequest;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    public function testDirectionsBuilderAvoidAndModeAndLanguageArrivalTime(): void
    {
        $request = GoogleMapsRequest::newDirectionsRequest(
            'Toronto', 'Montreal'
        )->withAvoid(AvoidableRoute::HIGHWAYS())
        ->withMode(TravelMode::BICYCLING())
        ->withLanguage(Language::ALBANIAN())
        ->withArrivalTime(1343641500);

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/origin=Toronto&destination=Montreal&mode=bicycling&avoid=highways&language=sq&arrival_time=1343641500';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testDirectionsBuilderDepartureTimeAndAlternativesAndMode(): void
    {
        $request = GoogleMapsRequest::newDirectionsRequest(
            'Brooklyn', 'Queens'
        )->withDepartureTime(1343641500)
        ->withAlternatives(true)
        ->withMode(TravelMode::TRANSIT());

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/origin=Brooklyn&destination=Queens&mode=transit&alternatives=true&departure_time=1343641500';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testDirectionsBuilderWaypointAndUnitsAndRegion(): void
    {
        $request = GoogleMapsRequest::newDirectionsRequest(
            'Boston,MA', 'Concord,MA'
        )->withPlaceNameWaypoint('Charlestown,MA')
        ->withPlaceNameWaypoint('Lexington,MA')
        ->withUnits(UnitSystem::IMPERIAL())
        ->withRegion('es')
        ->withDepartureTime(1399995076)
        ->withMode(TravelMode::DRIVING())
        ->withTrafficModel(TrafficModel::OPTIMISTIC());

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/origin=Boston,MA&destination=Concord,MA&mode=driving&waypoints=Charlestown,MA|Lexington,MA&unit=imperial&region=es&departure_time=1399995076&traffic_model=optimistic';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testDirectionsBuilderModeTransitTrafficModelTransitModeRoutingPreferenceAndDepartureTime(): void
    {
        $request = GoogleMapsRequest::newDirectionsRequest(
            'Boston,MA', 'Concord,MA'
        )->withMode(TravelMode::TRANSIT())
        ->withTransitMode(TransitMode::RAIL())
        ->withTransitMode(TransitMode::BUS())
        ->withTransitRoutingPreference(TransitRoutingPreference::LESS_WALKING())
        ->withDepartureTime(1343641500);

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/origin=Boston,MA&destination=Concord,MA&mode=transit&departure_time=1343641500&transit_mode=rail|bus&transit_routing_preference=less_walking';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testDirectionsBuilderWaypoints(): void
    {
        $request = GoogleMapsRequest::newDirectionsRequest(
            'Boston,MA', 'Concord,MA'
        )->withGeolocationWaypoint('-37.81223', '144.96254', true)
        ->withPolylineWaypoint('lexeF{~wsZejrPjtye@', true)
        ->withPlaceNameWaypoint('Charlestown')
        ->withPlaceIdWaypoint('ChIJ7cv00DwsDogRAMDACa2m4K8')
        ->withOptimizedWaypoints();

        $generatedRequest = $request->getRequest();
        self::assertSame('GET', $generatedRequest->getMethod());

        $generatedUri = urldecode($generatedRequest->getUri()->__toString());
        $expectedUri = '/origin=Boston,MA&destination=Concord,MA&waypoints=optimize:true|via:-37.81223,144.96254|via:enc:lexeF{~wsZejrPjtye@|Charlestown|place_id:ChIJ7cv00DwsDogRAMDACa2m4K8';

        self::assertSame($expectedUri, $generatedUri);
    }

    public function testDirectionsDepartureAndArrivalBothSet(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Both arrival time and departure time cannot be specified for the Directions API');

        $request = GoogleMapsRequest::newDirectionsRequest(
            'Boston,MA', 'Concord,MA'
        )->withDepartureTime(123456789)
        ->withArrivalTime(123456789);

        $request->getRequest();
    }

    public function testDirectionsTrafficModelSetWithNoDrivingMode(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('The traffic_model can only be specified if the mode is set to driving');

        $request = GoogleMapsRequest::newDirectionsRequest(
            'Boston,MA', 'Concord,MA'
        )->withMode(TravelMode::BICYCLING())
        ->withTrafficModel(TrafficModel::BEST_GUESS());

        $request->getRequest();
    }

    public function testDirectionsTrafficModelSetWithoutDepartureTime(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('The traffic_model can only be specified if a departure time is set');

        $request = GoogleMapsRequest::newDirectionsRequest(
            'Boston,MA', 'Concord,MA'
        )->withMode(TravelMode::DRIVING())
        ->withTrafficModel(TrafficModel::BEST_GUESS());

        $request->getRequest();
    }

    public function testDirectionsTransitMode(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('The transit_mode can only be specified if the mode is set to transit');

        $request = GoogleMapsRequest::newDirectionsRequest(
            'Boston,MA', 'Concord,MA'
        )->withMode(TravelMode::DRIVING())
        ->withTransitMode(TransitMode::BUS());

        $request->getRequest();
    }
}
