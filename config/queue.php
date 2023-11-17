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
	| Maximum number of concurrent batches
	|--------------------------------------------------------------------------
	|
	| The maximum number of batches that can be run concurrently. For example,
	| if 1000 queue jobs are dispatched and this is set to 5 with a batch size
	| of 100, then 5 batches of 100 will be run concurrently and take two runs
	| of the queue to complete.
	|
	*/
	'max_concurrent_batches' => environment( 'QUEUE_MAX_CONCURRENT_BATCHES', 1 ),

	/*
	|--------------------------------------------------------------------------
	| Delete failed or processed queue items after a set time
	|--------------------------------------------------------------------------
	|
	| Delete failed or processed queue items after a set time in seconds.
	|
	*/
	'delete_after' => environment( 'QUEUE_DELETE_AFTER', 60 * 60 * 24 * 7 ),

	/*
	|--------------------------------------------------------------------------
	| Enable the Queue Admin Interface
	|--------------------------------------------------------------------------
	|
	| Enable the queue admin interface to display queue jobs.
	|
	*/
	'enable_admin' => environment( 'QUEUE_ENABLE_ADMIN', true ),

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
