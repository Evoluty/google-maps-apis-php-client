<?php

namespace GoogleMapClient;

use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class GoogleMapClient
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
        $query = $request->getUri()->getQuery();
        if (!strpos($query, '?')) {
            $query .= '?';
        }
        
        $apiRequestUri = $request->getUri()
            ->withScheme('https')
            ->withHost('maps.googleapis.com/maps/api/' . $api . '/json/')
            ->withQuery($query . '&key=' . $this->key);

        $response = $this->httpClient->sendRequest($request->withUri($apiRequestUri));

        $responseStatusCode = $response->getStatusCode();
        if ($responseStatusCode !== 200) {
            throw new \UnexpectedValueException('Unexpected status code from api: ' . $responseStatusCode);
        }
        
        $stdResult = json_decode($response->getBody()->__toString());
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \UnexpectedValueException('Unable to parse Google Api result');
        }

        return $stdResult;
    }

    public function sendTimezoneRequest(TimezoneRequest $request): TimezoneResponse
    {
        $apiResponse = $this->handleRequest($request->getRequest(), 'timezone');
        return TimezoneResponse::factory($apiResponse);
    }
}
