<?php
/**
 * Queue Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Queue Provider
	|--------------------------------------------------------------------------
	|
	| Define the queue provider used in the application.
	|
	*/
	'default' => 'wordpress',

	'batch_size' => 5,

	/*
	|--------------------------------------------------------------------------
	| Provider Configuration
	|--------------------------------------------------------------------------
	|
	| Control the configuration for the queue providers.
	|
	*/
	'wordpress' => [
		'delay' => 300,
	],
];
