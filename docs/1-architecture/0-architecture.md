Architecture
============

- [Architecture](#architecture)
	- [Service Provider](#service-provider)
		- [What would be a service provider?](#what-would-be-a-service-provider)
		- [Registering a Service Provider](#registering-a-service-provider)
	- [Writing a Service Provider](#writing-a-service-provider)
		- [Service Provider Structure](#service-provider-structure)
	- [Automatic Registration with WordPress Events](#automatic-registration-with-wordpress-events)
- [Service Container](#service-container)
- [Facades](#facades)
	- [Aliases](#aliases)

## Service Provider
Service providers act as the key method of extending the framework and
bootstrapping essential services. Core application functionality will be defined
and encapsulated entirely in a service provider. Your own application, as well
as all core Mantle services, are bootstrapped via Service Providers.

But, what do we mean by "bootstrapped"? In general, we mean registering things,
including registering service container bindings, event listeners, middleware,
and even routes. Service providers are the central place to configure your
application.

### What would be a service provider?
A good example of what should be a service provider would be a feature in your
application. For example, a network of sites have a syndication feature. The
feature could be wrapped into a single service provider which would bootstrap
and setup all required services. The service provider would be the starting
point for that feature.

### Registering a Service Provider
The application stores service providers in the `config/app.php` file includes
with Mantle. There is a `providers` array of classes in that file that include
all providers the application will initialize on each request.

```php
// Inside of config/app.php...
'providers' => [

	// Add provider here...
	App\Providers\App_Service_Provider::class,
],
```

## Writing a Service Provider
Service providers extend the `Mantle\Framework\Service_Provider` class and
include a `register` and `boot` method. The `register` method is used to
register application services with the application container. The `boot` method
is used to boot provider, setup any classes, register any WordPress hooks, etc.
The `boot` method should always call the parent boot method via `parent::boot();`.

A service provider can be generated for you by running the following command:

```bash
wp mantle make:provider <name>
```

### Service Provider Structure
```php
namespace App;

use Mantle\Framework\Service_Provider;

/**
 * Example_Provider Service Provider
 */
class Example_Provider extends Service_Provider {

	/**
	 * Register the service provider.
	 */
	public function register() {
		// Register the provider.
		$this->app->singleton(
			'binding-to-register',
			function( $app ) {
				return new Essential_Service( $app );
			}
		);
	}

	/**
	 * Boot the service provider.
	 */
	public function boot() {
		parent::boot();

		// Boot the provider.
	}
}
```

## Automatic Registration with WordPress Events
The service provider supports magic methods to automatically register provider
methods with WordPress actions and filters. The service provider will
automatically register hooks for the provider by checking for methods that use
the format of `on_{hook}` and `on_{action}_at_{priority}` as method names. Both
actions and filters are supported using the same method naming convention.

```php
class Example_Provider extends Service_Provider {
	// ...

	public function on_wp_loaded() {
		// Called on wp_loaded at priority 10.
	}

	public function on_admin_screen_at_99() {
		// Called on admin_screen at priority 99.
	}
}
```

# Service Container
The service container is a powerful tool for managing class dependencies and
performing dependency injection with ease. Most function calls are performed
through the service container and support dynamic dependency injection without
any need to configure it.

Here is an example of the global instance of `Shared_Object` being injected into
the controller's constructor. The instance is a global singleton the service
container dynamically included as a parameter to the controller's constructor.

```php
namespace App\Http\Controllers;

use App\Shared_Object;

class Example_Controller extends \Mantle\Framework\Http\Controller {
	public function __construct( Shared_Object $object ) {
		$this->object = $object;
	}

	public function method( $id ) {
		return $this->object->get( $id );
	}
}
```

For more information about the service container and the underlying concept of
Dependency Injection, read this document on [Understanding Dependency Injection](https://php-di.org/doc/understanding-di.html).

# Facades
Facades are a static interface to the instances available from the service
container. Instead of determining the underlying class or resolving it through
the application, a facade will provide a single-line interface to call a
singleton object from the container.

```php
use Mantle\Framework\Facade\Config;

echo Config::get( 'app.attribute' );
```

In this example, the config facade is a wrapper for the `config` singleton instance of `Mantle\Framework\Config\Repository` in the application's service container.

## Aliases
Aliases provide a root namespace level way of interfacing with classes in the
framework. When combined with facades, they can provide a simple way of
interfacing with singleton objects deep in the framework.


```php
Log::info( 'My log message!' );

// Can be rewritten as...
mantle_app()['log']->info( 'My log message!' );
```
