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
	'default' => environment( 'CACHE_DRIVER', 'wordpress' ),

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
			'driver'   => 'redis',
			'host'     => environment( 'REDIS_HOST', '127.0.0.1' ),
			'password' => environment( 'REDIS_PASSWORD', '' ),
			'port'     => environment( 'REDIS_PORT', 6379 ),
			'scheme'   => environment( 'REDIS_SCHEME', 'tcp' ),
		],
	],
];
