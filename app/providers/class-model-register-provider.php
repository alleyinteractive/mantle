<?php
/**
 * Model_Register_Provider class file.
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Framework\Support\Providers\Model_Register_Provider as Service_Provider;

/**
 * Model Register Provider
 *
 * Provides registration for models to allow post types, taxonomies, and other object types
 * to be automatically registered with WordPress.
 */
class Model_Register_Provider extends Service_Provider {
	/**
	 * Register the service provider.
	 */
	public function register() {
		parent::register();

		// ...
	}

	/**
	 * Bootstrap the service provider.
	 */
	public function boot() {
		parent::boot();

		// ...
	}
}
