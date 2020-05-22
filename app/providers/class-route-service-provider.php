<?php
/**
 * Route_Service_Provider class file.
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Framework\Providers\Route_Service_Provider as Service_Provider;

/**
 * Route Service Provider
 */
class Route_Service_Provider extends Service_Provider {
	/**
	 * Define routes for the application.
	 *
	 * @return void
	 */
	public function map() {
		$this->map_web_routes();
	}

	/**
	 * Define web routes.
	 */
	protected function map_web_routes() {
		// todo: repalce with some abstraction to allow for testing.
		require_once mantle_base_path( 'routes/web.php' );
	}
}
