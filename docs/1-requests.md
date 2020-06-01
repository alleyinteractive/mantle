Requests
========

Mantle provides a MVC framework on-top of WordPress. You can add a route fluently and send a response straight back without needing to work with WordPress's `add_rewrite_rule()` at all.

```php
Route::get( '/example-route', function() {
	return 'Welcome!';
} );

Route::get( '/hello/{who}', function( $name ) {
	return "Welcome {$name}!";
} );
```

Routes are defined int he `routes/web.php` file by default and controlled by application's `Route_Service_Provider` located in `mantle`.

## Available Router Methods
The router has all HTTP request methods available:

```php
Route::get( $uri, $callback );
Route::post( $uri, $callback );
Route::put( $uri, $callback );
Route::patch( $uri, $callback );
Route::delete( $uri, $callback );
Route::options( $uri, $callback );
```

## Requests Pass Through
By default, requests will pass down to WordPress if there is no match in Mantle. That can be changed inside of `Route_Service_Provider`. If the request doesn't have a match, the request will 404 and terminate before going through WordPress's require rules.

```php
/**
 * Route_Service_Provider class file.
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Framework\Facade\Request;
use Mantle\Framework\Providers\Route_Service_Provider as Service_Provider;

/**
 * Route Service Provider
 */
class Route_Service_Provider extends Service_Provider {
	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
		parent::boot();

		$this->allow_pass_through_requests();
	}
}
```

## Responses
To come!
