<?php namespace Nickfan\MoSms;

use Illuminate\Support\ServiceProvider;

class MoSmsServiceProvider extends ServiceProvider {

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
		$this->package('nickfan/mosms', 'mosms', __DIR__.'/../../');

		$app = $this->app;
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerMoSms();
	}

	public function registerMoSms() {
		$this->app->singleton('mosms',function($app){
			return new \Nickfan\MoSms\MoSms($this->app['config']->get('mosms::gateway'));
		});
		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function() {
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('MoSms', 'Nickfan\MoSms\Facades\MoSms');
		});
	}
	public function registerMoClient() {
		$this->app->singleton('moclient',function($app){
			$settings = $this->app['config']->get('mosms::gateway');
			return new \Nickfan\MoSms\MoClient($settings['gwUrl'],$settings['userId'],$settings['password'],$settings['pszSubPort']);
		});
		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function() {
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('MoClient', 'Nickfan\MoSms\Facades\MoClient');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'mosms',
			'moclient',
			);
	}

}
