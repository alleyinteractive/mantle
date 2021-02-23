<?php
/**
 * Mantle Application
 *
 * @package Mantle
 */

use Mantle\Contracts;
use Mantle\Framework\Application;
use Mantle\Http\Request;

/**
 * Instantiate the application
 */
$app = new Application();

/**
 * Register the main contracts that power the application.
 */
$app->singleton(
	Contracts\Console\Kernel::class,
	App\Console\Kernel::class,
);

$app->singleton(
	Contracts\Http\Kernel::class,
	App\Http\Kernel::class,
);

$app->singleton(
	Contracts\Exceptions\Handler::class,
	App\Exceptions\Handler::class
);

// Load the Application's Kernel depending on the context it was called.
if ( defined( 'WP_CLI' ) && \WP_CLI ) {
	$app_kernel = $app->make( Contracts\Console\Kernel::class );
	$app_kernel->handle();
} else {
	// Boot up the HTTP Kernel.
	$app_kernel = $app->make( Contracts\Http\Kernel::class );
	$app_kernel->handle( Request::capture() );
}

return $app;
