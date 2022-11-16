<?php
/**
 * Plugin Name: Mantle
 * Plugin URI:  https://github.com/alleyinteractive/mantle
 * Description: A framework for powerful WordPress development
 * Author:      Alley
 * Author URI:  https://alley.co/
 * Text Domain: mantle
 * Domain Path: /languages
 * Version:     0.1
 *
 * Mantle is a derivative work of Laravel by Taylor Otwell (licensed MIT).
 *
 * @package Mantle
 */

/**
 * Mantle - A framework for powerful WordPress development.
 *
 * @link https://github.com/alleyinteractive/mantle/
 *
 * @author Alley Interactive
 * @package Mantle
 */

namespace App;

use Mantle\Contracts;
use Mantle\Http\Request;

/**
 * Mantle Application Base Directory
 *
 * @var string
 */
defined( 'MANTLE_BASE_DIR' ) || define( 'MANTLE_BASE_DIR', __DIR__ ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound

/*
|--------------------------------------------------------------------------
| Load Composer
|--------------------------------------------------------------------------
|
| Check if Composer has been installed and attempt to load it. You can remove
| this block of code if Composer is being loaded outside of the plugin.
|
*/
if ( ! getenv( 'MANTLE_SKIP_COMPOSER_INSTALL' ) ) {
	if ( ! file_exists( __DIR__ . '/vendor/wordpress-autoload.php' ) ) {
		add_action(
			'admin_notices',
			function() {
				printf(
					'<div class="notice notice-error"><p>%s</p></div>',
					esc_html__( 'Mantle requires a `composer install` to run properly.', 'mantle' )
				);
			}
		);

		return;
	} else {
		require_once __DIR__ . '/vendor/wordpress-autoload.php';
	}
}

/*
|--------------------------------------------------------------------------
| Load the Application
|--------------------------------------------------------------------------
|
| Load the Mantle application from the bootstrap file.
|
*/
$app = require_once __DIR__ . '/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run the Mantle Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request and send it
| the application's kernel (which depends on the context upon which it was
| called). For the console, the kernel's `handle` method is not called intentionally.
|
*/
if ( defined( 'WP_CLI' ) && \WP_CLI ) {
	$app_kernel = $app->make( Contracts\Console\Kernel::class );
} else {
	// Boot up the HTTP Kernel.
	$app_kernel = $app->make( Contracts\Http\Kernel::class );
	$app_kernel->handle( Request::capture() );
}
