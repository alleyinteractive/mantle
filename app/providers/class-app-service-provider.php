<?php
/**
 * Application Service Provider
 *
 * @package Mantle
 */

namespace App\Providers;

use App\Jobs\Example_Job;
use Mantle\Framework\Service_Provider;

/**
 * Application Service Provider
 */
class App_Service_Provider extends Service_Provider {
	/**
	 * Register any application services.
	 */
	public function register() {
		// todo.
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
		// todo.
		$post = get_post( 1 );
		Example_Job::dispatch( $post );
	}
}
