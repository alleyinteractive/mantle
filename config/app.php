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
		Mantle\Framework\Database\Factory_Service_Provider::class,
		Mantle\Framework\Providers\Console_Service_Provider::class,
		Mantle\Framework\Providers\Error_Service_Provider::class,
		Mantle\Framework\Providers\Queue_Service_Provider::class,
		Mantle\Framework\Providers\Docs_Service_Provider::class,

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
		'Config'  => Mantle\Framework\Facade\Config::class,
		'Log'     => Mantle\Framework\Facade\Log::class,
		'Request' => Mantle\Framework\Facade\Request::class,
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
