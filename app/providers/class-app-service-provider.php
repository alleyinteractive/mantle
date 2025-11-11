<?php
/**
 * Application Service Provider
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Application\App_Service_Provider as Service_Provider;
use Mantle\Scheduling\Schedule;
use Mantle\Types\Validator_Group as Group;

/**
 * Application Service Provider
 */
class App_Service_Provider extends Service_Provider {
	/**
	 * Register any application services.
	 */
	public function register(): void {
		// Add application registration here.
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		// Boot the application here.

		$plugin = new Group();

		/**
		 * You can also use alleyinteractive/wp-type-extension here to boot
		 * application features manually.
		 *
		 * $plugin->include(
		 *   new Example_Feature(),
		 * );
		 */

		$plugin->boot();
	}
}
