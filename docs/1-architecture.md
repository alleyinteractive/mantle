Architecture
============

## Service Provider
Service providers act as the key method of extending the framework and bootstrapping essential services. Core application functionality will be defined and encapsulated entirely in a service provider. Your own application, as well as all core Mantle services, are bootstrapped via Service Providers.

### Generating a Service Provider
A service provider can be generated for you by running the following command:

```bash
wp mantle make:provider <name>
```

### Example Service Provider
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
		// Boot the provider.
	}
}
```

### Registering Providers
All application service providers are registered in the `config/app.php` configuration file. The `providers` key provides a registry of all service providers loaded on each request.

```php
'providers' => [

	// Add provider here...
	App\Providers\App_Service_Provider::class,
],
```

## Service Container
The service container is a powerful tool for managing class dependencies and performing dependency injection with ease. Most function calls are performed through the service container and support dynamic dependency injection without any need to configure it.

Here is an example of the global instance of `Shared_Object` being injected into the controller's constructor. The instance is a global singleton the service container dynamically included as a parameter to the controller's contructor.

```php
<?php
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

## Facades

Facades are a static interface to the instances available from the service container.

```php
<?php
use Mantle\Framework\Facade\Config;

echo Config::get( 'app.attribute' );
```

In this example, the config facade is a wrapper for the `config` singleton instance of `Mantle\Framework\Config\Repository` in the application's service container.

## Aliases

Aliases provide a root namespace level way of interfacing with classes in the framework. When combined with facades, they can provide a simple way of interfacing with singleton objects deep in the framework.


```php
<?php
use Log;

Log::info( 'My log message!' );

// Can be rewritten as...
mantle_app()['log']->info( 'My log message!' );
```

A facade as an alias:

```php
<?php
use Config;

echo Config::get( 'app.attribute' );
```
