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
		$bootloader = require __DIR__ . '/../bootstrap/app.php';

		$bootloader->make( Kernel::class )->bootstrap();

		return $bootloader->get_application();
	}
}
