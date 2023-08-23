<?php
/**
 * Route_Service_Provider class file.
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Facade\Route;
use Mantle\Framework\Providers\Route_Service_Provider as Service_Provider;

/**
 * Route Service Provider
 */
class Route_Service_Provider extends Service_Provider {
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		parent::boot();

		$this->allow_pass_through_requests();
	}

	/**
	 * Define routes for the application.
	 */
	public function map(): void {
		Route::middleware( 'web' )->group( base_path( 'routes/web.php' ) );
		Route::middleware( 'rest-api' )->group( base_path( 'routes/rest-api.php' ) );
	}
}
