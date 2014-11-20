<?php namespace JCrowe\OpenWeather\Facades;

use Illuminate\Support\Facades\Facade;

class OpenWeather extends Facade {

    protected static function getFacadeAccessor() { return 'open-weather'; }
}