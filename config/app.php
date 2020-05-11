<?php
/**
 * Application Configuration
 *
 * @package Mantle
 */

return [
	/**
	 * Service Providers
	 */
	'providers' => [
		// Framework Providers.
		Mantle\Framework\Database\Factory_Service_Provider::class,

		// Application Providers.
		App\Providers\Model_Register_Provider::class,
		App\Providers\App_Service_Provider::class,
	],

	/**
	 * Application Aliases
	 */
	'aliases'   => [
		'App'    => Mantle\Framework\Facade\App::class,
		'Config' => Mantle\Framework\Facade\Config::class,
	],
];
