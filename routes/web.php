<?php
/**
 * Web Routes
 *
 * @package Mantle
 */

use Mantle\Facade\Http;
use Mantle\Facade\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Register a controller route:
|
|   Route::get( '/controller-route', Example_Controller::class . '@method_to_call' );
|
| Register a closure-based route:
|
|   Route::get( '/closure-route', function( \Mantle\Http\Request $request ) {
|       dd( $request->all() );
|   } );
|
| Register a route with variables:
|
|       Route::get( '/hello/{who}', function( $name ) {
|           return "Why hello {$name}!";
|       } );
|
*/

Route::get( '/', function () {
	return view( 'welcome' );
} );
