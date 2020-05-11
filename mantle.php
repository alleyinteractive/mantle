<?php
/**
 * Mantle - A framework for powerful WordPress development.
 *
 * @link https://github.com/alleyinteractive/mantle-site/
 *
 * @author Alley Interactive
 * @package Mantle
 */

namespace App;

/**
 * Mantle Application Base Directory
 *
 * @var string
 */
define( 'MANTLE_BASE_DIR', __DIR__ ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound

// Check if Composer has been installed.
if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
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
}

/**
 * Load the Composer Dependencies
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load the local version of the Mantle Framework if found.
 */
if ( file_exists( __DIR__ . '/../mantle-framework/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/../mantle-framework/vendor/autoload.php';
}

try {
	spl_autoload_register(
		\Mantle\Framework\generate_wp_autoloader( __NAMESPACE__, __DIR__ . '/app' )
	);
} catch ( \Exception $e ) {
	\wp_die( $e->getMessage() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Load the Mantle Application
 */
require_once __DIR__ . '/bootstrap/app.php';
