Request Lifecycle
==================

- [Request Lifecycle](#request-lifecycle)
	- [Registering Routes](#registering-routes)
		- [Closure Routes](#closure-routes)
		- [Controller Routes](#controller-routes)
		- [Named Routes](#named-routes)
		- [Route Groups](#route-groups)
		- [Available Router Methods](#available-router-methods)
	- [Requests Pass Through to WordPress Routing](#requests-pass-through-to-wordpress-routing)
	- [Route Middleware](#route-middleware)
		- [Example Middleware](#example-middleware)
		- [Authentication Middleware](#authentication-middleware)
	- [Responses](#responses)
		- [Strings & Arrays](#strings--arrays)
		- [Views](#views)
			- [View Location](#view-location)
		- [Redirect to Endpoint and Route](#redirect-to-endpoint-and-route)

Mantle provides a MVC framework on-top of WordPress. You can add a route
fluently and send a response straight back without needing to work with
WordPress's `add_rewrite_rule()` at all.

```php
Route::get( '/example-route', function() {
	return 'Welcome!';
} );

Route::get( '/hello/{who}', function( $name ) {
	return "Welcome {$name}!";
} );
```

Routes are defined int he `routes/web.php` file by default and controlled by application's `Route_Service_Provider` located in `mantle`.

## Registering Routes
Routes are registered for the application in the `routes/` folder of the application. Underneath all of it, routes are a wrapper on-top of [Symfony routing](https://symfony.com/doc/current/routing.html) with a fluent-interface on top.

### Closure Routes
At its most basic level, routes can be a simple anonymous function.

```php
Route::get( '/endpoint', function() {
	return 'Hello!';
} );
```

### Controller Routes
You can use a controller to handle routes as well. In the future, resource and automatic controller routing will be added.

```php
Route::get( '/controller-endpoint', Controller_Class::class . '@method_to_invoke' );
```

### Named Routes
Naming a route provides an easy-to-reference way of generating a URLs for a route.

```php
Route::get( '/posts/{slug}', [
	'name' => 'named-route',
	'callback' => function() { ... },
] );
```

### Route Groups
Routes can be registered in groups to make passing a common set of arguments easy.

```php
Route::group(
	[
		'middleware' => 'middleware-to-apply',
		'prefix'     => 'prefix/to/use',
	],
	function() {
		// Register a route with a prefix here!
	}
);
```

### Available Router Methods
The router has all HTTP request methods available:

```php
Route::get( $uri, $callback );
Route::post( $uri, $callback );
Route::put( $uri, $callback );
Route::patch( $uri, $callback );
Route::delete( $uri, $callback );
Route::options( $uri, $callback );
```

## Requests Pass Through to WordPress Routing
By default, requests will pass down to WordPress if there is no match in Mantle. That can be changed inside of `Route_Service_Provider`. If the request doesn't have a match, the request will 404 and terminate before going through WordPress's require rules. REST API requests will always pass through to WordPress and bypass Mantle routing.

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

## Route Middleware
Middleware can be used to filter incoming requests and the response sent to the browser. Think of it like a WordPress filter on top of the request and the end response.


### Example Middleware
```php
/**
 * Example_Middleware class file.
 *
 * @package Mantle
 */

namespace App\Middleware;

use Closure;
use Mantle\Framework\Http\Request;

/**
 * Example Middleware
 */
class Example_Middleware {
	/**
	 * Handle the request.
	 *
	 * @param Request $request Request object.
	 * @param Closure $next Callback to proceed.
	 */
	public function handle( Request $request, Closure $next ) {
		// Modify the request or bail early.

		$response = $next( $request );

		// Modify the response.
		return $response;
	}
}
```

### Authentication Middleware
Included with Mantle, a route can check a user's capability before allowing them to view a page.

```php
Route::get('/route-to-protect', function() {
	// The current user can 'manage_options'.
} )->middleware( 'can:manage_options', Example_Middleware::class );
```

## Responses
Responses for routed requests can come in all shapes and sizes. Underneath all of it, the response will always come out to be a `Symfony\Component\HttpFoundation\Response` object.

### Strings & Arrays
```php
Route::get( '/', function () {
    return 'Hello World';
} );

Route::get( '/', function () {
    return [ 1, 2, 3 ];
} );
```

### Views
WordPress template parts can be returned for a route.

```php
Route::get( '/', function () {
  return response()->view( 'template-parts/block', [ 'variable' => '123' ] );
} );
```

#### View Location
By default WordPress will only load a template part from the active theme and parent theme if applicable. Mantle supports loading views from a dynamic set of locations. Mantle support automatically register the current theme and parent theme as view locations.

### Redirect to Endpoint and Route
```php
Route::get( '/logout', function() {
	return response()->redirect_to( '/home' );
} );

Route::get( '/oh-no', function() {
	return response()->redirect_to_route( 'route_name' );
} );
```
