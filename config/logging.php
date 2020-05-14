<?php
/**
 * Logging Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Default Log Channel
	|--------------------------------------------------------------------------
	|
	| The default log channel that is used when calling the `Log` class.
	|
	*/
	'default' => 'stack',

	/*
	|--------------------------------------------------------------------------
	| Log Channel Configuration
	|--------------------------------------------------------------------------
	|
	| Provides configuration for various log channels. Supported drivers are 'new_relic',
	| 'ai_logger', 'slack', and 'error_log',
	|
	*/
	'channels' => [
		'stack' => [
			'driver'   => 'stack',
			'channels' => [ 'error_log', 'new_relic' ],
		],

		'error_log' => [
			'driver' => 'error_log',
			'level'  => 'error',
		],

		'new_relic' => [
			'driver' => 'new_relic',
			'level'  => 'error',
		],

		/**
		 * Log to the Alley Logger Package
		 *
		 * @link https://github.com/alleyinteractive/logger/
		 */
		'logger' => [
			'driver' => 'ai_logger',
			'level'  => 'info',
		],

		/**
		 * Log to a Slack Webhook
		 *
		 * @link https://api.slack.com/messaging/webhooks#create_a_webhook
		 */
		'slack'     => [
			'driver'   => 'slack',
			'url'      => '',
			'username' => 'Mantle Log',
			'emoji'    => ':boom:',
			'level'    => 'critical',
		],
	],
];
