<?php namespace JCrowe\OpenWeather;

use Illuminate\Support\ServiceProvider;

class OpenWeatherServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $namespace = 'open-weather';
        $path = __DIR__ . '/../../..';
        $this->package('j-crowe/open-weather', $namespace, $path);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('OpenWeather', function($app) {
            $config = $app->make('config');
            /** @var array $defaults */
            $defaults = $config->get('open-weather::options');
            $baseUrl = $config->get('open-weather::base_url');

            return OpenWeather::getInstance($defaults, $baseUrl);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('OpenWeather');
    }

}
