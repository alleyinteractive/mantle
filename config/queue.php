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
	'default' => environment( 'QUEUE_CONNECTION', 'wordpress' ),

	/*
	|--------------------------------------------------------------------------
	| Queue Batch Size
	|--------------------------------------------------------------------------
	|
	| The amount of items handled in one run of the queue.
	|
	*/
	'batch_size' => environment( 'QUEUE_BATCH_SIZE', 5 ),

	/*
	|--------------------------------------------------------------------------
	| Provider Configuration
	|--------------------------------------------------------------------------
	|
	| Control the configuration for the queue providers.
	|
	*/
	'wordpress' => [
		// Delay between queue runs in seconds.
		'delay' => environment( 'QUEUE_DELAY', 0 ),
	],
];
