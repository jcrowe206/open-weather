OpenWeather PHP Wrapper
=====

PHP Wrapper for the [Open Weather API](http://openweathermap.org/current)

This library does not require Laravel; however, a Laravel Service Provider is included.

## Installation

Install using composer:
    
    "require": {
        "j-crowe/open-weather": "dev-master"
    }
    
## Configuration

There are 2 required configurations - the Base URL and Default Guzzle Options.

Please see (here)[http://guzzle.readthedocs.org/en/latest/clients.html#request-options] for possible options
    
## Usage Without Laravel

See below for sample initialization code:
    
    <?php
    
    include_once 'vendor/autoload.php';
    
    // Note the configs that are required. Guzzle Opts are default options for Guzzle
    $baseUrl = 'http://api.openweathermap.org';
    $guzzleOpts = array(
        'timeout' => 3,
        'connect_timeout' => 3
    );
    
    $openWeather = OpenWeather::getInstance($guzzleOpts, $baseUrl);
    
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