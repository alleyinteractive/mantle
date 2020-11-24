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
	'default' => 'wordpress',

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
			'host'   => '127.0.0.1',
			'scheme' => 'tcp',
		],
	],
];
