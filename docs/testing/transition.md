# Transitioning to Test Framework

[[toc]]

The Mantle Test Framework can be used outside of projects that started as a
Mantle project, such as normal WordPress sites, themes, and plugins. The
framework can be added and loaded to your existing project's unit test.

::: tip Want to see a `/wp-content/`-rooted project that is using Mantle?

If you're interested in seeing a `/wp-content/`-rooted project that is setup to
use Mantle, checkout
[`alleyinteractive/create-mantle-app`](https://github.com/alleyinteractive/create-mantle-app).
:::
## Getting Started

This guide assumes that we are in a `wp-content/` rooted WordPress project.

### Install `alleyinteractive/mantle-framework` as a dependency.

If you do not have a `composer.json` file in your project initialize that with
`composer init`. Install the latest version of the `main` branch. Composer does
not need to be loaded on all requests unless you plan on using Mantle outside of
your unit tests.

```bash
composer require alleyinteractive/mantle-framework:dev-main
```

## Change Test Case

Unit Tests should extend themselves from Mantle's `Framework_Test_Case` class
in place of core's `WP_UnitTestCase` class.

```php
use Mantle\Framework\Testing\Framework_Test_Case;

class Test_Case extends Framework_Test_Case {

	public function test_example() {
		$this->go_to( home_url( '/' ) );
		$this->assertQueryTrue( 'is_home', 'is_archive' );
	}

	public function test_factory() {
		$post = static::factory()->post->create_and_get(); // WP_Post.

		// ...
	}
}
```

## Adjusting Unit Test Bootstrap

Commonly unit tests live inside of plugins or themes. For this use case, we're
going to adjust a theme's unit test bootstrap file to load the test framework.

::: tip
1. You might not need an autoloader if you are rolling your own.
2. The callback to `install()` is completely optional.
:::

```php
<?php
/**
 * Theme Testing using Mantle Framework
 */

namespace App\Tests;

// Install the Mantle Test Framework.
\Mantle\Framework\Testing\install(
	function() {
		// Setup any additional dependencies.

		\Mantle\Framework\Testing\tests_add_filter(
			'muplugins_loaded',
			function() {
				// Setup any dependencies once WordPress is loaded, such as themes.
				switch_theme( 'twentytwenty' );
			}
		);
	}
);

spl_autoload_register(
	\Mantle\generate_wp_autoloader( __NAMESPACE__, __DIR__ )
);
```
