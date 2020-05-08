<?php
/**
 * Application Configuration
 *
 * @package Mantle
 */

return [
	/**
	 * Application Service Providers
	 */
	'providers' => [
		Mantle\Framework\Database\Factory_Service_Provider::class,
	],

	/**
	 * Application Aliases
	 */
	'aliases'   => [
		'App'    => Mantle\Framework\Facade\App::class,
		'Config' => Mantle\Framework\Facade\Config::class,
	],
];
