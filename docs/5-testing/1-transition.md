Transitioning to Test Framework
======================================

- [Transitioning to Test Framework](#transitioning-to-test-framework)
	- [Getting Started](#getting-started)
		- [Add Composer Repositories](#add-composer-repositories)
		- [Install `alleyinteractive/mantle-framework` as a dependency.](#install-alleyinteractivemantle-framework-as-a-dependency)
	- [Change Test Case](#change-test-case)
	- [Adjusting Unit Test Bootstrap](#adjusting-unit-test-bootstrap)
	- [Configuring Continuous Integration](#configuring-continuous-integration)

The Mantle Test Framework can be used outside of projects that started as a
Mantle project such as normal WordPress sites, themes, and plugins. The
framework can be added and loaded to your existing theme's unit test.

## Getting Started

This guide assumes that we are in a `wp-content/` rooted WordPress project.

### Add Composer Repositories

If you do not have a `composer.json` file in your project initialize that with
`composer init`.

::: tip
This is only required until Mantle is open sourced.
:::

```bash
composer config repositories.mantle-framework git git@github.com:alleyinteractive/mantle-framework.git
composer config repositories.sml git git@github.com:alleyinteractive/sml.git
```

### Install `alleyinteractive/mantle-framework` as a dependency.

Install the latest version of the `main` branch. Composer does not need to be
loaded on all requests unless you plan on using Mantle outside of your unit tests.

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

```php
<?php
/**
 * Theme Testing using Mantle Framework
 */

use function Mantle\Framework\Testing\tests_add_filter;

if ( ! defined( 'WP_CONTENT_DIR' ) ) {
	define( 'WP_CONTENT_DIR', preg_replace( '#/wp-content/.*$#', '/wp-content', __DIR__ ) );
}

$preload_path = '/src/mantle/framework/testing/preload.php';

// Define the framework location.
define( 'MANTLE_FRAMEWORK_DIR', WP_CONTENT_DIR . '/vendor/alleyinteractive/mantle-framework' );

if ( ! file_exists( MANTLE_FRAMEWORK_DIR . $preload_path ) ) {
	echo "ERROR: Unable to find the mantle framework!\n";
	exit( 1 );
}

// Load some features that require early.
require_once MANTLE_FRAMEWORK_DIR . $preload_path;

/**
 * Setup our environment (theme, plugins).
 */
function _manually_load_environment() {
	// Load the Mantle Test Framework.
	require_once MANTLE_FRAMEWORK_DIR . '/src/autoload.php';

	// Set our theme.
	switch_theme( 'twenty-twenty' );

	/*
	 * Tests won't start until the uploads directory is scanned, so use the
	 * lightweight directory from the test install.
	 *
	 * @see https://core.trac.wordpress.org/changeset/29120.
	 */
	add_filter( 'pre_option_upload_path', function () {
		return ABSPATH . 'wp-content/uploads';
	} );

	if ( ! defined( 'JETPACK_DEV_DEBUG' ) ) {
		define( 'JETPACK_DEV_DEBUG', true );
	}

	// Set active plugins (if any).
	update_option( 'active_plugins', [
		'jetpack/jetpack.php',
	] );

	/*
	 * Disable Edit Flow notifications by default. If Edit Flow is enabled, the
	 * notifications module can hit errors because the unit test factory creates
	 * posts without authors.
	 */
	add_filter( 'ef_notification_status_change', '__return_false' );
}
tests_add_filter( 'muplugins_loaded', '_manually_load_environment' );

try {
	require_once MANTLE_FRAMEWORK_DIR . '/src/mantle/framework/testing/wordpress-bootstrap.php';
} catch ( \Throwable $throwable ) {
	echo "ERROR: Failed to load WordPress!\n";
	echo "{$throwable}\n";
	exit( 1 );
}
```

## Configuring Continuous Integration

Unit tests can be run through Continuous Integration services such as Travis CI.

::: tip
This script assumes that [`wp-cli`'s `install-wp-tests.sh`
script](https://github.com/wp-cli/scaffold-command/blob/master/templates/install-wp-tests.sh)
is located at `bin/install-wp-tests.sh`.
:::

```yml
# Travis CI (MIT License) configuration file
# @link https://travis-ci.org/

# Bionic image has PHP versions 7.1,7.2,7.3 pre-installed
dist: bionic

# Xenial does not start mysql by default
services:
  - mysql
  - memcached

# Declare project language.
# @link http://about.travis-ci.org/docs/user/languages/php/
language: php

# Git clone depth.
git:
  depth: 1

matrix:
    fast_finish: true

    include:
        - php: '7.3'
          env: WP_VERSION=trunk PHP_LINT=1
        - php: '7.3'
          env: WP_VERSION=latest PHP_LINT=1 WP_PHPCS=1
    allow_failures:
        - php: '7.3'
          env: WP_VERSION=trunk PHP_LINT=1

# Use this to prepare your build for testing.
# e.g. copy database configurations, environment variables, etc.
# Failures in this section will result in build status 'errored'.
before_script:
    # Turn off Xdebug. See https://core.trac.wordpress.org/changeset/40138.
    - phpenv config-rm xdebug.ini || echo "Xdebug not available"

    - export PATH="$HOME/.config/composer/vendor/bin:$PATH"
    - export WP_CORE_DIR=/tmp/wordpress/

    # Couple the PHPUnit version to the PHP version.
    - composer global require "phpunit/phpunit=6.1.*"

    - og_dir="$(pwd)"
    - theme_slug="theme-name"

    # Set up WordPress installation.
    - export WP_DEVELOP_DIR=/tmp/wordpress
    - bash bin/install-wp-tests.sh wordpress_unit_tests root '' localhost $WP_VERSION

    # Copy the wp-tests-config.php to the WP installation.
    - cp ${WP_TESTS_DIR-/tmp/wordpress-tests-lib}/wp-tests-config.php ${WP_CORE_DIR-/tmp/wordpress/}wp-tests-config.php

    # Set up the wp-content directory. This assumes that this repo name matches the theme name
    - |
      cd $og_dir
      echo $theme_slug

      # Go into the core directory and replace wp-content.
      rm -rf ${WP_CORE_DIR}wp-content
      mkdir ${WP_CORE_DIR}wp-content
      cp -R . "${WP_CORE_DIR}wp-content"

    # Install Composer
    - |
      cd ${WP_CORE_DIR}wp-content/
      composer install

      export PATH=$PATH:${og_dir}/vendor/bin/
      # After CodeSniffer install you should refresh your path.
      phpenv rehash
      phpcs --version

    # Hop into theme's directory.
    - cd ${WP_CORE_DIR}wp-content/themes/$theme_slug/

    # For debugging
    - php -v
    - phpunit --version
    - pwd

# Run test script commands.
# Default is specific to project language.
# All commands must exit with code 0 on success. Anything else is considered failure.
script:
    # Search for PHP syntax errors.
    #
    # Only need to run this once per PHP version.
    - if [[ "$PHP_LINT" == "1" ]]; then find . -type "f" -iname "*.php" | xargs -L "1" php -l; fi

    # WordPress Coding Standards.
    #
    # These are the same across PHP and WordPress, so we need to run them only once.
    #
    # @link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
    # @link http://pear.php.net/package/PHP_CodeSniffer/
    # -p flag: Show progress of the run.
    # -s flag: Show sniff codes in all reports.
    # -v flag: Print verbose output.
    # -n flag: Do not print warnings (shortcut for --warning-severity=0)
    # --standard: Use WordPress as the standard.
    # --extensions: Only sniff PHP files.
    - if [[ "$WP_PHPCS" == "1" ]]; then phpcs -v; fi

    # Test the theme's unit tests
    - phpunit --version
    - which phpunit
    - phpunit

notifications:
    email: false
```
