<?php
/**
 * Mantle Application
 *
 * @package Mantle
 */

use Mantle\Framework;

/**
 * Instantiate the application
 */
$app = new Framework\Application();

/**
 * Register the main contracts that power the application.
 */
$app->singleton(
	Framework\Contracts\Console\Kernel::class,
	App\Console\Kernel::class,
);

$app->singleton(
	Framework\Contracts\Http\Kernel::class,
	App\Http\Kernel::class,
);

// Load the Application's Kernel depending on the context it was called.
if ( defined( 'WP_CLI' ) && \WP_CLI ) {
	$app_kernel = $app->make( Framework\Contracts\Console\Kernel::class );
} else {
	// Boot up the HTTP Kernel.
	$app_kernel = $app->make( Framework\Contracts\Http\Kernel::class );
}

/**
 * Boot the Application
 */
$app_kernel->handle();

return $app;
