<?php
/**
 * Kernel class file.
 *
 * @package Mantle
 */

namespace App\Http;

use Mantle\Framework\Http\Kernel as Http_Kernel;

/**
 * Application HTTP Kernel
 *
 * Allows for customization of the HTTP Kernel on an application level.
 */
class Kernel extends Http_Kernel {
	/**
	 * The application's middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middleware_groups = [
		'web' => [],
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $route_middleware = [
		'can' => \Mantle\Framework\Auth\Middleware\Authorize::class,
	];
}
