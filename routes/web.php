<?php
/**
 * Web Routes
 *
 * @package Mantle
 */

use App\Http\Controller\Test_Controller;
use Mantle\Framework\Facade\Route;

Route::get( '/another-item', Test_Controller::class . '@method' );

// Route::get( '/another-item', function() {
// 	return 'Example Response';
// } );
