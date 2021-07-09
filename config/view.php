<?php
/**
 * View Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Compiled View Path
	|--------------------------------------------------------------------------
	|
	| This option determines where all the compiled Blade templates will be
	| stored for your application.
	*/

	'compiled' => environment( 'APP_VIEW_STORAGE', storage_path( 'framework/views' ) ),
];
