<?php
/**
 * Asset Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Asset Folder
	|--------------------------------------------------------------------------
	|
	| Specify the folder that built assets live in. This defaults to `build/` but
	| can be customized to any other path.
	|
	*/
	'path' => env( 'ASSET_BUILD_PATH', 'build' ),

	/*
	|--------------------------------------------------------------------------
	| Asset URL
	|--------------------------------------------------------------------------
	|
	| This URL is used to properly generate the URL to built assets.
	*/
	'url'  => env(
		'ASSET_BUILD_URL',
		function_exists( 'plugin_dir_url' ) ? \plugin_dir_url( __DIR__ ) . 'build' : '', // todo: replace with a framework helper method.
	),
];
