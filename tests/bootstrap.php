<?php
/**
 * Application Test Bootstrap
 *
 * @package App
 */

namespace App\Tests;

// Install the Mantle Test Framework.
\Mantle\Framework\Testing\install();

spl_autoload_register(
	\Mantle\Framework\generate_wp_autoloader( __NAMESPACE__, __DIR__ )
);
