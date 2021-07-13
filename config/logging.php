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
	'default' => environment( 'LOG_CHANNEL', 'stack' ),

	/*
	|--------------------------------------------------------------------------
	| Log Channel Configuration
	|--------------------------------------------------------------------------
	|
	| Provides configuration for various log channels. Supported drivers are 'new_relic',
	| 'ai_logger', 'slack', 'error_log', and 'custom'.
	|
	*/
	'channels' => [
		'stack' => [
			'driver'   => 'stack',
			'channels' => [ 'error_log' ],
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
		'slack' => [
			'driver'   => 'slack',
			'url'      => environment( 'SLACK_URL', '' ),
			'username' => environment( 'SLACK_USERNAME', 'Mantle Log' ),
			'emoji'    => ':boom:',
			'level'    => 'critical',
		],

		/*
		|--------------------------------------------------------------------------
		| Custom Log Channel
		|--------------------------------------------------------------------------
		|
		| Supports passing to a specific handler by class name or Monolog Handler
		| instance via the 'handler' attribute.
		|
		*/
		'custom' => [
			'driver'  => 'custom',
			'handler' => 'Example\Class\Name',
		],
	],
];
