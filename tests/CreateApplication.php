<?php
/**
 * Create_Application trait file.
 *
 * @package App
 */

namespace App\Tests;

use App\Http\Kernel;
use Mantle\Application\Application;

/**
 * Concern for creating the application instance.
 */
trait CreateApplication {
	/**
	 * Creates the application from the application instance.
	 *
	 * @return \Mantle\Application\Application
	 */
	public function create_application(): \Mantle\Contracts\Application {
		// Allow non-mantle-site usage.
		if ( ! file_exists( __DIR__ . '/../bootstrap/app.php' ) ) {
			echo "Application bootstrap not found: creating new instance...";
			return new Application( __DIR__ . '/../', home_url( '/' ) );
		}

		$app = require __DIR__ . '/../bootstrap/app.php';

		$app->make( Kernel::class )->bootstrap();

		return $app;
	}
}
