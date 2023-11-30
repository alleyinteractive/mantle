<?php
/**
 * REST API Routes
 *
 * @package Mantle
 */

use Mantle\Facade\Route;

/*
|--------------------------------------------------------------------------
| REST API Routes
|--------------------------------------------------------------------------
|
| Register a closure-based route:
|
|   Route::get( '/closure-route', function( \WP_REST_Request $request ) {
|       dd( $request );
|   } );
|
*/

Route::rest_api( '/example-namespace', function () {
	//
} );
