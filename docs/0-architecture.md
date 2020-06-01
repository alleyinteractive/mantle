---
title: Architecture
---

## Service Provider

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
