<?php
/**
 * Console Commands
 *
 * @package Mantle
 */

use Mantle\Facade\Console;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of your Closure based console commands.
| Each Closure is bound to a command instance allowing a simple approach
| to interacting with each command's IO methods. Even though this
| file is included in your application configuration, feel free to
| remove it if you are not using console commands.
|
*/

Console::command( 'hello {name}', function ( $name ) {
	$this->info( "Hello, {$name}!" ); // @phpstan-ignore-line Undefined variable
} )->describe( 'Greet a user by name' );
