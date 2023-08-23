<?php
/**
 * Kernel class file.
 *
 * @package Mantle
 */

namespace App\Console;

use Mantle\Facade\Console;
use Mantle\Framework\Console\Kernel as Console_Kernel;

/**
 * Application Console Kernel
 *
 * By default, the application will automatically register any command in this
 * directory as well as any command registered in 'routes/console.php'.
 */
class Kernel extends Console_Kernel {
	/**
	 * The commands provided by the application.
	 *
	 * @var array<int, class-string<\Mantle\Console\Command>>
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

		require base_path( 'routes/console.php' ); // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomFunction
	}
}
