<?php
/**
 * Application Test Bootstrap
 */

namespace Tests;

use function Mantle\Framework\Testing\tests_add_filter;

$mantle_dir = getenv( 'MANTLE_DIR' );
if ( empty( $mantle_dir ) ) {
	$mantle_dir = preg_replace( '#^(.*?/wp-content/).*$#', '$1private/mantle-framework', __DIR__ );
}

if ( ! file_exists( $mantle_dir . '/src/mantle/framework/testing/preload.php' ) ) {
	echo "ERROR: Unable to find the mantle framework!\n";
	exit( 1 );
}

// Load some features that require early
require_once $mantle_dir . '/src/mantle/framework/testing/preload.php';

tests_add_filter(
	'muplugins_loaded',
	function () {
		require_once dirname( __DIR__ ) . '/mantle.php';
		require_once MANTLE_FRAMEWORK_DIR . '/src/autoload.php';

		try {
			spl_autoload_register(
				\Mantle\Framework\generate_wp_autoloader( __NAMESPACE__, __DIR__ )
			);
		} catch ( \Exception $e ) {
			\wp_die( $e->getMessage() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
);

require_once $mantle_dir . '/src/mantle/framework/testing/wordpress-bootstrap.php';
