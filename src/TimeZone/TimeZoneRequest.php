<?php

declare(strict_types=1);

namespace GoogleMapsClient\TimeZone;

use GoogleMapsClient\GoogleMapsRequest;
use GoogleMapsClient\Language;
use Psr\Http\Message\RequestFactoryInterface;

class TimeZoneRequest extends GoogleMapsRequest
{
    /** @var TimeZoneLocation */
    private $location;

    /** @var int */
    private $timestamp;

    /** @var Language|null */
    private $language = null;

    public function __construct(TimeZoneLocation $location, int $timestamp, RequestFactoryInterface $requestFactory = null)
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
