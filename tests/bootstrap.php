<?php
/**
 * Application Test Bootstrap
 *
 * @package App
 */

namespace App\Tests;

// Install the Mantle Test Framework.
\Mantle\Framework\Testing\install(
	function() {
		\Mantle\Framework\Testing\tests_add_filter(
			'muplugins_loaded',
			function() {
				require_once __DIR__ . '/../mantle.php';
			}
		);
	}
);

spl_autoload_register(
	\Mantle\Framework\generate_wp_autoloader( __NAMESPACE__, __DIR__ )
);
