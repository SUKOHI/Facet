<?php namespace Sukohi\Facet;

use Illuminate\Support\ServiceProvider;

class FacetServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var  bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
		$this->app->singleton('command.facet', function ($app) {

			return $app['Sukohi\Facet\Commands\FacetCommand'];

		});
		$this->commands('command.facet');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['facet'];
    }

}