<?php
/**
 * Web Routes
 */

use Mantle\Framework\Facade\Route;

// todo: not registering multiple
Route::get( '/test', function() {
	return 'TEST';
} );


Route::get( '/another-item', function() {
	return 'this is a response';
} );

Route::get( '/aaaa', function() {
	return 'this is a response';
} );
