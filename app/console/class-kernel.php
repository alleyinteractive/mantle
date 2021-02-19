<?php
/**
 * Kernel class file.
 *
 * @package Mantle
 */

namespace App\Console;

use Mantle\Console\Kernel as Console_Kernel;

/**
 * Application Console Kernel
 */
class Kernel extends Console_Kernel {
	/**
	 * The commands provided by the application.
	 *
	 * @var array
	 */
	protected $commands = [
		// ...
	];

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	public function commands(): void {
		$this->load( __DIR__ );
	}
}
