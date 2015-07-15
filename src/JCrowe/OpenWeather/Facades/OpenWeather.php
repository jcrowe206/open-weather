<?php namespace JCrowe\OpenWeather\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade accessor for the open-weather library
 *
 * Class OpenWeather
 * @package JCrowe\OpenWeather\Facades
 */
class OpenWeather extends Facade {

    protected static function getFacadeAccessor() { return 'open-weather'; }
}