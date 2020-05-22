<?php
/**
 * Web Routes
 */

use Mantle\Framework\Facade\Route;

Route::get( '/test', function() {
	return 'TEST';
} );


Route::get( '/another-item', function() {
	return 'this is a response';
} );

Route::get( '/aaaa', function() {
	return 'this is a response';
} );
