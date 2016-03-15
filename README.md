OpenWeather PHP Wrapper
=====

[![Build Status](https://travis-ci.org/jcrowe206/open-weather.svg?branch=master)](https://travis-ci.org/jcrowe206/open-weather)


PHP Wrapper for the [Open Weather API](http://openweathermap.org/current)

This library does not require Laravel; however, a Laravel Service Provider is included.

## Installation

Install using composer:
    
    "require": {
        "j-crowe/open-weather": "1.2"
    }
    
or via CLI   

    composer require j-crowe/open-weather 1.2
    
## Configuration

There are 3 required configurations:

First, the app_id - an environment variable named 'OPENWEATHER_APPID' that must be set in your application

Please see [here](http://openweathermap.org/appid) to get one

The other two - the Base URL and Default Guzzle Options.

Please see [here](http://docs.guzzlephp.org/en/5.3/clients.html#request-options) for possible options
    
## Usage Without Laravel

See below for sample initialization code:
    
    <?php
    
    include_once 'vendor/autoload.php';
    
    use JCrowe\OpenWeather\OpenWeather;

    // Note the configs that are required. Guzzle Opts are default options for Guzzle
    $baseUrl = 'http://api.openweathermap.org';
    $guzzleOpts = array(
        'timeout' => 3,
        'connect_timeout' => 3
    );
    $appId = 'abcdefghijklmnop1234567890';
    
    $openWeather = OpenWeather::getInstance($guzzleOpts, $baseUrl, $appId);
    
    $response = $openWeather->getByCityName('los angeles');
    
    if($response->isValid()) {
        print_r($response->getWeatherData());
    }

    ?>
    
## Usage With Laravel

In `config/app.php`, add the following to the service providers array.

    array(
        ...
        'JCrowe\OpenWeather\Providers\OpenWeatherServiceProvider',
    )

Then add the following to the aliases array.
    
    'OpenWeather' => 'JCrowe\OpenWeather\Facades\OpenWeather'

Publish the configs using `php artisan config:publish j-crowe/open-weather`, which should include the default configuration, which should include the default configuration.
