# Requests

- [Requests](#requests)
	- [Registering Routes](#registering-routes)
		- [Closure Routes](#closure-routes)
		- [Controller Routes](#controller-routes)
		- [Named Routes](#named-routes)
		- [Route Groups](#route-groups)
		- [Available Router Methods](#available-router-methods)
		- [Requests Pass Through to WordPress Routing](#requests-pass-through-to-wordpress-routing)
	- [Route Model Binding](#route-model-binding)
		- [Implicit Binding](#implicit-binding)
			- [Customizing The Default Key Name](#customizing-the-default-key-name)
		- [Explicit Binding](#explicit-binding)
			- [Customizing The Resolution Logic](#customizing-the-resolution-logic)
		- [Route Middleware](#route-middleware)
			- [Example Middleware](#example-middleware)
			- [Authentication Middleware](#authentication-middleware)
	- [Responses](#responses)
			- [Strings & Arrays](#strings--arrays)
		- [Views](#views)
			- [View Location](#view-location)
				- [Default View Locations](#default-view-locations)
		- [Redirect to Endpoint and Route](#redirect-to-endpoint-and-route)
	- [REST API Routing](#rest-api-routing)
		- [Registering Routes](#registering-routes-1)
		- [Using Middleware](#using-middleware)
	- [Events](#events)
		- [New Relic](#new-relic)

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

Routes are defined in the `routes/web.php` file by default and controlled by
application's `Route_Service_Provider` located in the application

## Registering Routes
Routes are registered for the application in the `routes/` folder of the
application. Underneath all of it, routes are a wrapper on-top of [Symfony
routing](https://symfony.com/doc/current/routing.html) with a fluent-interface
on top.

### Closure Routes
At its most basic level, routes can be a simple anonymous function.

```php
Route::get( '/endpoint', function() {
  return 'Hello!';
} );
```

### Controller Routes
You can use a controller to handle routes as well. In the future, resource and
automatic controller routing will be added.

```php
Route::get( '/controller-endpoint', Controller_Class::class . '@method_to_invoke' );
```

### Named Routes
Naming a route provides an easy-to-reference way of generating a URLs for a
route.

```php
Route::get( '/posts/{slug}', [
  'name' => 'named-route',
  'callback' => function() { ... },
] );
```

### Route Groups
Routes can be registered in groups to make passing a common set of arguments
easy.

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

### Requests Pass Through to WordPress Routing
By default, requests will pass down to WordPress if there is no match in Mantle.
That can be changed inside of `Route_Service_Provider`. If the request doesn't
have a match, the request will 404 and terminate before going through
WordPress's require rules. REST API requests will always pass through to
WordPress and bypass Mantle routing.

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

## Route Model Binding
Routes support model binding that will automatically resolve a model based on a
route parameter and a type-hint on the route method. This supports implicit and
explicit binding from a service provider.

### Implicit Binding
Mantle will automatically resolve models that are type-hinted for the route's
method. For example:

```php
Route::get( 'users/{user}', function ( App\User $user ) {
	return $user->title;
} );
```

Since the `$user` variable is type-hinted as `App\User` model and the variable
name matches the `{user}` segment, Mantle will automatically inject the model
instance that has an ID matching the corresponding value from the request URI.
If a matching model instance is not found in the database, a 404 HTTP response
will automatically be generated.

#### Customizing The Default Key Name

If you would like model binding to use a default database column other than id
when retrieving a given model class, you may override the `get_route_key_name`
method on the model:

```php
/**
 * Get the route key for the model.
 *
 * @return string
 */
public function get_route_key_name(): string {
  return 'slug';
}
```

### Explicit Binding
To register an explicit binding, use the router's model method to specify the
class for a given parameter. You should define your explicit model bindings in
the boot method of the `Route_Service_Provider` class:

```php
public function boot() {
  parent::boot();

  Route::model( 'user', App\User::class );
}
```

Next, define a route that contains a {user} parameter:

```php
Route::get( 'profile/{user}', function ( App\User $user ) {
  //
} );
```

Since we have bound all {user} parameters to the `App\User` model, a `User`
instance will be injected into the route. So, for example, a request to
`profile/1` will inject the `User` instance from the database which has an ID of
`1`.

If a matching model instance is not found in the database, a 404 HTTP response
will be automatically generated.

#### Customizing The Resolution Logic

If you wish to use your own resolution logic, you may use the Route::bind
method. The Closure you pass to the bind method will receive the value of the
URI segment and should return the instance of the class that should be injected
into the route:

```php
/**
 * Bootstrap any application services.
 *
 * @return void
 */
public function boot() {
  parent::boot();

  Route::bind( 'user', function ( $value ) {
    return App\User::where( 'name', $value )->firstOrFail();
  } );
}
```

Alternatively, you may override the `resolve_route_binding` method on your
model. This method will receive the value of the URI segment and should return
the instance of the class that should be injected into the route:

```php
/**
 * Retrieve the model for a bound value.
 *
 * @param  mixed       $value
 * @param  string|null $field
 * @return static|null
 */
public function resolve_route_binding( $value, $field = null ) {
  return $this->where( 'name', $value )->firstOrFail();
}
```

### Route Middleware
Middleware can be used to filter incoming requests and the response sent to the
browser. Think of it like a WordPress filter on top of the request and the end
response.

#### Example Middleware
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
		$request->setMethod( 'POST' );

		/**
		 * @var Mantle\Framework\Http\Response
		 */
		$response = $next( $request );

    // Modify the response.
		$response->headers->set( 'Special-Header', 'Value' );

    return $response;
  }
}
```

#### Authentication Middleware
Included with Mantle, a route can check a user's capability before allowing them
to view a page.

```php
Route::get('/route-to-protect', function() {
  // The current user can 'manage_options'.
} )->middleware( 'can:manage_options', Example_Middleware::class );
```

## Responses
Responses for routed requests can come in all shapes and sizes. Underneath all
of it, the response will always come out to be a
`Symfony\Component\HttpFoundation\Response` object. The `response()` helper
exists to help with returning responses.

#### Strings & Arrays
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
By default WordPress will only load a template part from the active theme and
parent theme if applicable. Mantle supports loading views from a dynamic set of
locations. Mantle support automatically register the current theme and parent
theme as view locations.

##### Default View Locations
- Active Theme
- Parent of Active Theme
- `{root of mantle site}/views`

For more information about views, read the 'Templating' documentation.

### Redirect to Endpoint and Route
Redirects can be generated using the `response()` helper.

```php
Route::get( '/logout', function() {
  return response()->redirect_to( '/home' );
} );

Route::get( '/old-page', function() {
  return response()->redirect_to( '/home', 301 );
} );

Route::get( '/oh-no', function() {
  return response()->redirect_to_route( 'route_name' );
} );
```

## REST API Routing
Mantle supports registering to the WordPress REST API directly. REST API Routes
are registered underneath with native core functions and does not use the
Symfony-based routing that web requests pass through.

### Registering Routes
Registering a REST API route requires a different function call if you do not
wish to use a closure.

```php
Route::rest_api( 'namespace/v1', '/route-to-use', function() {
  return [ 1, 2, 3 ];
} );
```

Routes can also be registered using the same HTTP verbs web routes use with some
minor differences.

```php
Route::rest_api(
	'namespace/v1',
	function() {
		Route::get(
			'/example-group-get',
			function() {
				return [ 1, 2, 3 ];
			}
		);

		Route::get(
			'/example-with-param/(?P<slug>[a-z\-]+)',
			function( WP_REST_Request $request) {
				return $request['slug'];
			}
		);
	}
);
```

REST API routes can also be registered using the same arguments you would pass
to `register_rest_route()`.

```php
Route::rest_api(
	'namespace/v1',
	function() {
		Route::get(
			'/example-endpoint',
			function() {
				// This callback can be omitted, too.
			},
			[
				'permission_callback' => function() {
					// ...
				}
			]
		);
	}
);
```

### Using Middleware
REST API routes also support the same [Route Middleware](#route-middleware) that
web requests use. The only difference is that web requests are passed a Mantle
Request object while REST API requests are passed a `WP_REST_Request` one.

```php
Route::middleware( Example_Middleware::class )->group(
	function() {
		Route::rest_api( 'namespace/v1', '/example-route', function() { /* ... */ } );
	}
)
```

## Events

Mantle-powered routes for both web and REST API will fire the `Route_Matched`
event when a route has been matched. It will always include the current request
object. For web routes it will include the `Route` object as the route property.
For REST API requests it will include an array of information about the current
matched route.

```php
use Mantle\Framework\Http\Routing\Events\Route_Matched;
Event::listen(
	Route_Matched::class,
	function( Route_Matched $event ) {
		var_dump( $event->route );
		var_dump( $event->request->ip() );
	}
);
```

### New Relic

Using the `Route_Matched` event Mantle will automatically fill in transaction
information for New Relic if the extension is loaded. All requests will
have the transaction name properly formatted instead of relying on New Relic to
fill in the blanks.
