<?php

declare(strict_types=1);

namespace GoogleMapsClient\TimeZone;

use GoogleMapsClient\Classes\Geolocation;
use GoogleMapsClient\Classes\Language;
use GoogleMapsClient\GoogleMapsRequest;
use Psr\Http\Message\RequestFactoryInterface;

class TimeZoneRequest extends GoogleMapsRequest
{
    /** @var Geolocation */
    private $location;

    /** @var \DateTime */
    private $dateTime;

    /** @var Language|null */
    private $language = null;

    public function __construct(Geolocation $location, ?RequestFactoryInterface $requestFactory = null)
    {
        parent::__construct($requestFactory);
        $this->location = $location;
    }

    public function withLanguage(Language $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function withDateTime(\DateTime $dateTime): self
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    protected function getQueryString(): string
    {
        if ($this->dateTime === null) {
            $this->dateTime = new \DateTime();
        }

        $args = [
            'location' => strval($this->location),
            'timestamp' => $this->dateTime->getTimestamp(),
        ];

        if (!empty($this->language)) {
            $args['language'] = $this->language->getValue();
        }

        return http_build_query($args);
    }
}
