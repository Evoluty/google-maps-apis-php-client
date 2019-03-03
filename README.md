# Google Maps APIs PHP Client
_A PHP client for Google Maps APIs_

This library helps building query and call the Google Maps APIs  
This will parse results and give usable and typed objects as a result

[![Build Status](https://travis-ci.org/Evoluty/google-maps-apis-php-client.svg?branch=master)](https://travis-ci.org/Evoluty/google-maps-apis-php-client)
[![codecov](https://codecov.io/gh/Evoluty/google-maps-apis-php-client/branch/master/graph/badge.svg)](https://codecov.io/gh/Evoluty/google-maps-apis-php-client)

## Installation
Run `composer require evoluty/google-maps-client`  or check directly on the [packagist website](https://packagist.org/packages/evoluty/google-maps-client)

## Usage
Use like the following (example with the TimeZone API)
```php
$googleClient = new GoogleMapClient('<your_api_key>');

$request = GoogleMapRequest::newTimeZoneRequest(
    new TimeZoneLocation('39.6034810', '-119.6822510'), 1331161200
)->withLanguage(Language::CZECH());

$timeZoneResponse = $googleClient->sendTimeZoneRequest($request);

```

The response type depends on the API that you are calling and will contain public typed getters that match the Google API response


## APIs

At the moment the following API are implemented:
* TimeZone API
* Directions API
