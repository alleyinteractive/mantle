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
	 * @var array<int, callable|class-string>
	 */
	protected $middleware = [];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array<string, array<int, callable|class-string>>
	 */
	protected $middleware_groups = [
		'web'      => [
			\Mantle\Http\Routing\Middleware\Setup_WordPress::class,
			\Mantle\Http\Routing\Middleware\Substitute_Bindings::class,
			\Mantle\Http\Routing\Middleware\Wrap_Template::class,
		],
		'rest-api' => [],
	];

	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array<string, callable|class-string>
	 */
	protected $route_middleware = [
		'can' => \Mantle\Auth\Middleware\Authorize::class,
	];
}
