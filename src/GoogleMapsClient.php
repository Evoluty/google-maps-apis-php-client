<?php

namespace GoogleMapsClient;

use GoogleMapsClient\TimezoneApi\TimezoneRequest;
use GoogleMapsClient\TimezoneApi\TimezoneResponse;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class GoogleMapsClient
{
    /** @var string */
    private $key;

    /** @var ClientInterface */
    private $httpClient;

    public function __construct(string $key, ClientInterface $httpClient = null)
    {
        $this->key = $key;
        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
    }

    private function handleRequest(RequestInterface $request, string $api): \stdClass
    {
        $queryString = str_replace('/', '?', $request->getUri()->__toString());

        $apiRequestUri = $request->getUri()
            ->withScheme('https')
            ->withHost('maps.googleapis.com')
            ->withPath('maps/api/' . $api . '/json')
            ->withQuery($queryString . '&key=' . $this->key);

        $response = $this->httpClient->sendRequest($request->withUri($apiRequestUri));

        $responseStatusCode = $response->getStatusCode();
        if ($responseStatusCode !== 200) {
            throw new \UnexpectedValueException('Unexpected status code from api: ' . $responseStatusCode);
        }

        $stdResult = json_decode($response->getBody()->__toString());
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \UnexpectedValueException('Unable to parse Google Api result');
        }

        // @todo: better error handling
        if ($stdResult->status !== 'OK') {
            throw new \UnexpectedValueException($stdResult->status . ' ' . $stdResult->errorMessage);
        }

        return $stdResult;
    }

    public function sendTimezoneRequest(TimezoneRequest $request): TimezoneResponse
    {
        $apiResponse = $this->handleRequest($request->getRequest(), 'timezone');
        return TimezoneResponse::factory($apiResponse);
    }
}
