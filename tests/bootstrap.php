<?php
/**
 * Application Test Bootstrap
 *
 * @package App
 */

namespace App\Tests;

// Install the Mantle Test Framework.
\Mantle\Testing\manager()
	->loaded( fn () => require_once __DIR__ . '/../mantle.php' )
	->install();
