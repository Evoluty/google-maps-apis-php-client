<?php

namespace GoogleMapsClient\TimezoneApi;

use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Language;
use Psr\Http\Message\RequestFactoryInterface;

class TimezoneRequest extends GoogleMapsRequest
{
    /** @var TimezoneLocation */
    private $location;

    /** @var int */
    private $timestamp;

    /** @var Language|null */
    private $language = null;

    public function __construct(TimezoneLocation $location, int $timestamp, RequestFactoryInterface $requestFactory = null)
    {
        $this->location = $location;
        $this->timestamp = $timestamp;
        parent::__construct($requestFactory);
    }

    public function withLanguage(Language $language): self
    {
        $this->language = $language;
        return $this;
    }

    protected function getQueryString(): string
    {
        $args = [
            'location' => strval($this->location),
            'timestamp' => $this->timestamp,
        ];

        if (!empty($this->language)) {
            $args['language'] = $this->language->getValue();
        }

        return http_build_query($args);
    }
}
