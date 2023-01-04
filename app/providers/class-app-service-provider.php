<?php
/**
 * Application Service Provider
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Application\App_Service_Provider as Service_Provider;

/**
 * Application Service Provider
 */
class App_Service_Provider extends Service_Provider {
	/**
	 * Register any application services.
	 */
	public function register() {
		// Add application registration here.
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
		// Boot the application here.
	}

	/**
	 * Schedule any commands for the Application
	 *
	 * @param \Mantle\Scheduling\Schedule $schedule Scheduler instance.
	 */
	protected function schedule( $schedule ) {
		// Schedule any commands, jobs, callbacks, etc. here.
	}
}
