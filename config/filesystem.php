<?php
/**
 * Filesystem Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Default Filesystem Disk
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default filesystem disk that should be used
	| by the framework. The "local" disk, as well as a variety of cloud
	| based disks are available to your application. Just store away!
	|
	*/
	'default' => environment( 'FILESYSTEM_DRIVER', 'local' ),

	/*
	|--------------------------------------------------------------------------
	| Filesystem Disks
	|--------------------------------------------------------------------------
	|
	| Here you may configure as many filesystem "disks" as you wish, and you
	| may even configure multiple disks of the same driver. Defaults have
	| been setup for each driver as an example of the required options.
	|
	| Supported Drivers: "local", "ftp", "sftp", "s3"
	|
	*/
	'disks' => [
		'local' => [
			'driver' => 'local',
		],

		's3' => [
			'driver'                   => 's3',
			'key'                      => environment( 'S3_KEY', '' ),
			'secret'                   => environment( 'S3_SECRET', '' ),
			'region'                   => environment( 'S3_REGION', 'us-east-2' ),
			'bucket'                   => environment( 'S3_BUCKET', '' ),
			'temporary_url_expiration' => environment( 'S3_TEMPORARY_URL_EXPIRATION', 3600 ),
		],
	],
];
