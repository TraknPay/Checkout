<?php

namespace TraknPay\Checkout;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider {

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
	public function boot() {

		$this->handleConfigs();
		// $this->handleMigrations();
		// $this->handleViews();
		// $this->handleTranslations();
		$this->handleRoutes();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {

		$this->app->singleton('checkout', function ($app) {
			return new Checkout();
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {

		return [];
	}

	private function handleConfigs() {

		$configPath = __DIR__ . '/../config/traknpay_payment_gateway.php';

		$this->publishes([$configPath => config_path('traknpay_payment_gateway.php')]);

		$this->mergeConfigFrom($configPath, 'traknpay_payment_gateway');
	}

	private function handleTranslations() {

		$this->loadTranslationsFrom(__DIR__.'/../lang', 'packagename');
	}

	private function handleViews() {

		$this->loadViewsFrom(__DIR__.'/../views', 'packagename');

		$this->publishes([__DIR__.'/../views' => base_path('resources/views/vendor/packagename')]);
	}

	private function handleMigrations() {

		$this->publishes([__DIR__ . '/../migrations' => base_path('database/migrations')]);
	}

	private function handleRoutes() {

		include __DIR__ . '/../web.php';
		//$this->app->make('TraknPay\Checkout\Checkout');
	}
}
