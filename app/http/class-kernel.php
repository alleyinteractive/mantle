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
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
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
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $route_middleware = [
		'can' => \Mantle\Framework\Auth\Middleware\Authorize::class,
	];
}
