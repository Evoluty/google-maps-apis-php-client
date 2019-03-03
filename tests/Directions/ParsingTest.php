<?php

declare(strict_types=1);

namespace GoogleMapsClient\Tests\Directions;

use GoogleMapsClient\Classes\TravelMode;
use GoogleMapsClient\Directions\DirectionsResponse;
use PHPUnit\Framework\TestCase;

class ParsingTest extends TestCase
{
    public function testTimeZoneResponseParsing(): void
    {
        $apiResponse = require __DIR__ . '/DirectionApiResult.php';

        $directionsResponse = DirectionsResponse::factory($apiResponse);

        /* Response metadata */
        self::assertSame('OK', $directionsResponse->getStatus());
        self::assertNull($directionsResponse->getErrorMessage());

        /* Response data */

        // Geocoded waypoints
        self::assertSame('ChIJCSF8lBZEwokRhngABHRcdoI', $directionsResponse->getGeocodedWaypoints()[0]->getPlaceId());
        self::assertSame(['political', 'sublocality', 'sublocality_level_1'], $directionsResponse->getGeocodedWaypoints()[0]->getTypes());
        self::assertSame('OK', $directionsResponse->getGeocodedWaypoints()[0]->getGeocoderStatus());
        self::assertSame('ChIJK1kKR2lDwokRBXtcbIvRCUE', $directionsResponse->getGeocodedWaypoints()[1]->getPlaceId());
        self::assertSame(['political', 'sublocality'], $directionsResponse->getGeocodedWaypoints()[1]->getTypes());
        self::assertSame('OK', $directionsResponse->getGeocodedWaypoints()[1]->getGeocoderStatus());

        // Route
        self::assertSame('40.7293779', $directionsResponse->getRoutes()[0]->getBounds()->getNortheast()->getLatitude());
        self::assertSame('-73.7902347', $directionsResponse->getRoutes()[0]->getBounds()->getNortheast()->getLongitude());
        self::assertSame('40.6754845', $directionsResponse->getRoutes()[0]->getBounds()->getSouthwest()->getLatitude());
        self::assertSame('-73.9441766', $directionsResponse->getRoutes()[0]->getBounds()->getSouthwest()->getLongitude());
        self::assertSame('Map data ©2019 Google', $directionsResponse->getRoutes()[0]->getCopyrights());
        self::assertSame('s}gwF~eibMTBJcGDuBHqD~Auu@bBov@p@e[NmJlAgm@LmH?iA@YJO@Ih@qT\\cGDaALqBJm@FoAF}DEuIAg@Qo@AeB@q@KuDm@HgEt@cDf@u@Ns@A]Am@GsFiB{A_@oBUoDGs@Iq@Iu@Sq@Wo@_@uA}@qCuB{CqCsF{FwD}C_GkE}HcGYU_@e@[g@Wo@Us@Q}@ScBoA{KwAaKiBmKS}Bs@aOMmCS{@[i@OOWOo@My@GWISMQSOWq@}BYq@a@g@_@YeAc@g@[eBuBmBmBoAmAW_@QY]{@WqAOuAw@aIYyBg@cBs@{Ay@aAcAw@iAe@cF}@sAWi@Qc@WiAw@cAiAw@yAm@_B_@}AWyAUuBKmBEgC@_CFkBLoB^iDNmBDsBKqBOuAMo@c@aBkAiDm@uB]oBg@sE]uBe@kBaAcC}@wAwAkBq@o@cAs@sCkB}@{@u@cAo@mAa@eA[mAY_BOmBE{@EkGCkFGyBKsC[sEo@_Dg@aBwBaFqAeD]gAq@qCs@iDc@wAUo@_@q@{@mAeCyDcAuBqCsGo@qAWm@yE_LG[OaAQeA_A_Fi@uBk@{C{@mFIQeAqCmAwBm@cA{@}CMs@Ky@Ew@EuBDyBP}ERkB\\uBh@yB^uAj@eBZkBLqBDuBEgFCaEG_T?gFFeF@aGEyEEiBQmFe@oI_@{Ew@{Gs@yEyAyHkBoJ_CeJFQGk@SsBW{BA[?Uc@uBEu@Aw@D}@Bw@oA_@_A[UO{@_@e@OQAoBAiDAwGTw@Ba@D_A`@eAt@wCbBcBp@QFa@JW@cGjBuC`AsBl@qDhADVrApIjC[', $directionsResponse->getRoutes()[0]->getOverviewPolyline()->getPoints());
        self::assertSame('Jackie Robinson Pkwy', $directionsResponse->getRoutes()[0]->getSummary());
        self::assertSame([], $directionsResponse->getRoutes()[0]->getWarnings());
        self::assertSame([], $directionsResponse->getRoutes()[0]->getWaypointOrder());

        // Leg
        self::assertSame('10.5 mi', $directionsResponse->getRoutes()[0]->getLegs()[0]->getDistance()->getText());
        self::assertSame(16847, $directionsResponse->getRoutes()[0]->getLegs()[0]->getDistance()->getValue());
        self::assertSame('28 mins', $directionsResponse->getRoutes()[0]->getLegs()[0]->getDuration()->getText());
        self::assertSame(1702, $directionsResponse->getRoutes()[0]->getLegs()[0]->getDuration()->getValue());
        self::assertSame('48 mins', $directionsResponse->getRoutes()[0]->getLegs()[0]->getDurationInTraffic()->getText());
        self::assertSame(2904, $directionsResponse->getRoutes()[0]->getLegs()[0]->getDurationInTraffic()->getValue());
        self::assertSame('Queens, NY, USA', $directionsResponse->getRoutes()[0]->getLegs()[0]->getEndAddress());
        self::assertSame('40.7282259', $directionsResponse->getRoutes()[0]->getLegs()[0]->getEndLocation()->getLatitude());
        self::assertSame('-73.7948332', $directionsResponse->getRoutes()[0]->getLegs()[0]->getEndLocation()->getLongitude());
        self::assertSame('Brooklyn, NY, USA', $directionsResponse->getRoutes()[0]->getLegs()[0]->getStartAddress());
        self::assertSame('40.678183', $directionsResponse->getRoutes()[0]->getLegs()[0]->getStartLocation()->getLatitude());
        self::assertSame('-73.9441613', $directionsResponse->getRoutes()[0]->getLegs()[0]->getStartLocation()->getLongitude());
        self::assertSame([], $directionsResponse->getRoutes()[0]->getLegs()[0]->getTrafficSpeedEntry());
        self::assertSame('42.3781732', $directionsResponse->getRoutes()[0]->getLegs()[0]->getViaWaypoints()[0]->getLocation()->getLatitude());
        self::assertSame('-71.0602489', $directionsResponse->getRoutes()[0]->getLegs()[0]->getViaWaypoints()[0]->getLocation()->getLongitude());
        self::assertSame(6, $directionsResponse->getRoutes()[0]->getLegs()[0]->getViaWaypoints()[0]->getStepIndex());
        self::assertSame(0.2067913715981807, $directionsResponse->getRoutes()[0]->getLegs()[0]->getViaWaypoints()[0]->getStepInterpolation());
        self::assertSame('42.4473497', $directionsResponse->getRoutes()[0]->getLegs()[0]->getViaWaypoints()[1]->getLocation()->getLatitude());
        self::assertSame('-71.2271531', $directionsResponse->getRoutes()[0]->getLegs()[0]->getViaWaypoints()[1]->getLocation()->getLongitude());
        self::assertSame(12, $directionsResponse->getRoutes()[0]->getLegs()[0]->getViaWaypoints()[1]->getStepIndex());
        self::assertSame(1., $directionsResponse->getRoutes()[0]->getLegs()[0]->getViaWaypoints()[1]->getStepInterpolation());

        // Step
        self::assertSame('1.9 mi', $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getDistance()->getText());
        self::assertSame(3058, $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getDistance()->getValue());
        self::assertSame('9 mins', $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getDuration()->getText());
        self::assertSame(546, $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getDuration()->getValue());
        self::assertSame('40.6761563', $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getEndLocation()->getLatitude());
        self::assertSame('-73.9081531', $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getEndLocation()->getLongitude());
        self::assertSame('Head south on Atlantic Ave toward Atlantic Ave Pass by Popeyes Louisiana Kitchen (on the right in 1.2 mi)', $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getHtmlInstructions());
        self::assertSame('s}gwF~eibMTBJcGBk@@iAB}@@}@@Y@[^kPFkCDeBNuHTqKFwC@i@@m@HmDNaH@a@T_KDkCDiAX{MJkER_KHoDHkDHiDFqD@a@BcA@uAH}DHaEHoDHyDHuDHsDF_EHsDJ}D@oB@e@Ac@', $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getPolyline()->getPoints());
        self::assertSame('40.678183', $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getStartLocation()->getLatitude());
        self::assertSame('-73.9441613', $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getStartLocation()->getLongitude());
        self::assertSame(TravelMode::DRIVING, $directionsResponse->getRoutes()[0]->getLegs()[0]->getSteps()[0]->getTravelMode()->getValue());
    }
}
