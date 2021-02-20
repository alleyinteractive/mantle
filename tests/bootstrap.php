<?php
/**
 * Application Test Bootstrap
 *
 * @package App
 */

namespace App\Tests;

// Install the Mantle Test Framework.
\Mantle\Testing\install(
	function() {
		\Mantle\Testing\tests_add_filter(
			'muplugins_loaded',
			function() {
				require_once __DIR__ . '/../mantle.php';
			}
		);
	}
);

spl_autoload_register(
	\Mantle\generate_wp_autoloader( __NAMESPACE__, __DIR__ )
);
