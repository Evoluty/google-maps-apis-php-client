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

    public function __construct(TimeZoneLocation $location, ?\DateTime $dateTime = null, ?RequestFactoryInterface $requestFactory = null)
    {
        parent::__construct($requestFactory);
        $this->location = $location;
        if ($dateTime === null) {
            $dateTime = new \DateTime();
        }
        $this->timestamp = $dateTime->getTimestamp();
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
