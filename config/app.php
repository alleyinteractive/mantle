<?php
/**
 * Application Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| Enable detailed error messages with stack traces will be shown on every error
	| that occurs within your application. If disabled, a simple generic error page
	| is shown.
	|
	*/
	'debug' => defined( 'WP_DEBUG' ) && WP_DEBUG,

	/*
	|--------------------------------------------------------------------------
	| Application Service Providers
	|--------------------------------------------------------------------------
	|
	| Providers listed here will be autoloaded for every request on the application.
	|
	 */
	'providers' => [
		// Framework Providers.
		Mantle\Framework\Filesystem\Filesystem_Service_Provider::class,
		Mantle\Framework\Database\Factory_Service_Provider::class,
		Mantle\Framework\Providers\Console_Service_Provider::class,
		Mantle\Framework\Providers\Error_Service_Provider::class,
		Mantle\Framework\Providers\Model_Service_Provider::class,
		Mantle\Framework\Providers\Queue_Service_Provider::class,
		Mantle\Framework\Query_Monitor\Query_Monitor_Service_Provider::class,
		Mantle\Framework\Providers\New_Relic_Service_Provider::class,
		Mantle\Framework\Database\Pagination\Paginator_Service_Provider::class,
		Mantle\Framework\Cache\Cache_Service_Provider::class,

		// Application Providers.
		App\Providers\App_Service_Provider::class,
		App\Providers\Route_Service_Provider::class,
	],

	/*
	|--------------------------------------------------------------------------
	| Application Aliases
	|--------------------------------------------------------------------------
	|
	| These are aliases that will be available to the entire application without
	| the need use the proper namespace.
	|
	 */
	'aliases'   => [
		'App'     => Mantle\Framework\Facade\App::class,
		'Cache'   => Mantle\Framework\Facade\Cache::class,
		'Config'  => Mantle\Framework\Facade\Config::class,
		'Event'   => Mantle\Framework\Facade\Event::class,
		'Log'     => Mantle\Framework\Facade\Log::class,
		'Queue'   => Mantle\Framework\Facade\Queue::class,
		'Request' => Mantle\Framework\Facade\Request::class,
		'Route'   => Mantle\Framework\Facade\Route::class,
		'View'    => Mantle\Framework\Facade\View::class,
		'Storage' => Mantle\Framework\Facade\Storage::class,
	],

	/*
	|--------------------------------------------------------------------------
	| Application Namespace
	|--------------------------------------------------------------------------
	|
	| Used to provide a configurable namespace for class generation.
	|
	*/
	'namespace' => 'App',
];
