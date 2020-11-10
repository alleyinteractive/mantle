<?php
/**
 * Create_Application trait file.
 *
 * @package App
 */

namespace App\Tests;

use Mantle\Framework\Application;

/**
 * Concern for creating the application instance.
 */
trait Create_Application {
	/**
	 * Creates the application from the application instance.
	 *
	 * @return \Mantle\Framework\Application
	 */
	public function create_application(): \Mantle\Framework\Contracts\Application {
		// Allow non-mantle-site usage.
		if ( ! file_exists( __DIR__ . '/../bootstrap/app.php' ) ) {
			echo "Application bootstrap not found: creating new instance...";
			return new Application( __DIR__ . '/../', home_url( '/' ) );
		}

		return require __DIR__ . '/../bootstrap/app.php';
	}
}
