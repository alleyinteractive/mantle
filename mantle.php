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
use Mantle\Framework\Boot_Manager;
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
if ( ! class_exists( Boot_Manager::class ) ) {
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
| Load the Mantle application from the bootstrap file. This step is actually
| optional as Mantle can operate without any application kernel or configuration.
| This will allow you greater control over the application and make it feel more
| like a Laravel-esque application.
|
*/

$app = require_once __DIR__ . '/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Boot the Mantle Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can boot the application given the current
| context and let Mantle take it from here.
|
*/

Boot_Manager::instance( $app )->boot();
