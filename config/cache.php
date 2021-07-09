<?php
/**
 * Cache Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Default Cache Store
	|--------------------------------------------------------------------------
	|
	| Define the default cache store used. Supports "redis", "wordpress", and
	| "array".
	|
	*/
	'default' => environment( 'APP_CACHE', 'wordpress' ),

	/*
	|--------------------------------------------------------------------------
	| Cache Stores
	|--------------------------------------------------------------------------
	|
	| Cache stores can use supported drivers in any combination.
	|
	*/
	'stores' => [
		'wordpress' => [
			'driver' => 'wordpress',
		],
		'array'     => [
			'driver' => 'array',
		],
		'redis'     => [
			'driver' => 'redis',
			'host'   => environment( 'REDIS_HOST', '' ),
			'scheme' => environment( 'REDIS_SCHEME', '' ),
		],
	],
];
