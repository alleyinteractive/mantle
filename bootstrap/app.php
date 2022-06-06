<?php
/**
 * Mantle Application
 *
 * @package Mantle
 */

use Mantle\Contracts;
use Mantle\Framework\Application;

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

return $app;
