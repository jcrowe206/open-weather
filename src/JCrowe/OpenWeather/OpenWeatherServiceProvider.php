<?php namespace JCrowe\OpenWeather;

use Illuminate\Support\ServiceProvider;

class OpenWeatherServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('j-crowe/open-weather');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
        $this->app['OpenWeather'] = $this->app->share(function($app) {
            return new OpenWeather;
        });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('OpenWeather', 'JCrowe\OpenWeather\Facades\OpenWeather');
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
