<?php
/**
 * Route_Service_Provider class file.
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Framework\Facade\Request;
use Mantle\Framework\Providers\Route_Service_Provider as Service_Provider;

/**
 * Route Service Provider
 */
class Route_Service_Provider extends Service_Provider {
	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
		parent::boot();

		$this->prevent_pass_through_requests();
	}

	/**
	 * Define routes for the application.
	 */
	public function map() {
		$this->map_web_routes();
	}

	/**
	 * Define web routes.
	 */
	protected function map_web_routes() {
		// todo: replace with some abstraction to allow for testing.
		require_once mantle_base_path( 'routes/web.php' );
	}
}
