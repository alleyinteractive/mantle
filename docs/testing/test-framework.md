# Testing Framework

[[toc]]

Mantle provides a PHPUnit test framework to make it easier to test your code
with WordPress. It is focused on making testing your application faster and
easier, allowing unit testing to become top of mind when building your site.
Mantle includes many convenient helpers to allow you to expressively test your
applications.

With Mantle, your application's tests live in your `tests` directory. Tests
should extend from the `App\Tests\Test_Case` test case, which include booting
and the use of your Mantle application inside of your test case. Unit tests can
be run using Composer:

```bash
composer run phpunit
```

Test cases can be generated using `wp-cli`:

```bash
wp mantle make:test <Namespace\Test_Name>
```

## Setting up the Test Framework

Mantle's Test Framework provides a special bootstrapper and installer for
WordPress. It is common in WordPress to use a _separate_ WordPress codebase when
running unit tests. In Mantle, you use the same codebase and a separate
database. As long as your test suite isn't writing to any files, a singular
codebase is a preferable setup, especially if you want to use xdebug to step
through your test.

The Mantle Test Framework will work out of the box defining a set of constants
to install WordPress. The default set of constants can be overridden using a
test config in your WordPress root directory, named `wp-tests-config.php`. See
[the sample config in the Mantle
Framework](https://github.com/alleyinteractive/mantle-framework/blob/main/src/mantle/testing/wp-tests-config-sample.php)
to get started. This config is similar to `wp-config.php` and defines many of
the same constants. Most importantly, it defines the database information, which
*must* be different from your environment's database. If you reuse the same
database, your data could be lost!

The default configuration will install WordPress using a `localhost` database
named `wordpress_unit_tests` with the username/password pair of `root/root`. All
constants can be overridden using the `wp-tests-config.php` file or your unit
test's bootstrap file.

Lastly, see this repository's [`tests/bootstrap.php`
file](https://github.com/alleyinteractive/mantle/blob/main/tests/bootstrap.php)
for examples of how to load the Mantle Test Framework in your project.

### Why This Instead of WordPress Core's Test Suite?

We hope nobody interprets Mantle's Test Framework as a slight against WordPress
Core's test suite. We :heart: WordPress Core's test suite and Mantle's Test
Framework is unequivocally a derivative work of it.

WordPress Core's test suite ("wordpress-develop", if you will) is a wonderful
test suite for testing WordPress itself. We, and many others in the WordPress
community, have been repurposing it for years to help us run plugin and theme
tests. That's worked fine, but it's not optimal. Mantle's Test Framework tries
to incorporate the best parts of WordPress Core's test suite, but remove the
unnecessary bits. Without having to worry about older versions of PHP, that also
allows Mantle's Test Framework to use the latest versions of PHPUnit itself.

### Drop-in Support for Core Test Suite

The Mantle Test Framework supports legacy support for core's test suite methods,
including `go_to()` and `factory()` among others. Projects are able to switch to
the Mantle Test Framework without needing to rewrite any existing unit tests.
The `Mantle\Testing\Framework_Test_Case` class should be extended from
for any non-Mantle based project. For more information, see [Transitioning to
Test Framework](./1-transition.md).

## Users

The Mantle Test Framework provides a method, `acting_as( $user )` to execute a
test as a given user or a user in the given role. This is best explained through
code, so here are some examples of using this method:

```php
$this->acting_as( 'administrator' );
$this->assertTrue( current_user_can( 'manage_options' ) );
```

```php
$this->acting_as( 'contributor' );
$this->get( '/some-admin-only-page/' )
     ->assertForbidden();
```

```php
$user = $this->acting_as( 'editor' );
```

```php
$this->acting_as( $some_user_created_elsewhere );
```

### Assertions

Mantle's Test Case provides some assertions above and beyond PHPUnit's, largely
influenced by `WP_UnitTestCase`. Here's a runthrough.

Assert the given item is/is not a `WP_Error`:
* `assertWPError( $actual, $message = '' )`
* `assertNotWPError( $actual, $message = '' )`

Asserts that the given fields are present in the given object:
* `assertEqualFields( $object, $fields )`

Asserts that two values are equal, with whitespace differences discarded:
* `assertDiscardWhitespace( $expected, $actual )`

Asserts that two values are equal, with EOL differences discarded:
* `assertEqualsIgnoreEOL( $expected, $actual )`

Asserts that the contents of two un-keyed, single arrays are equal, without
accounting for the order of elements:
* `assertEqualSets( $expected, $actual )`

Asserts that the contents of two keyed, single arrays are equal, without
accounting for the order of elements:
* `assertEqualSetsWithIndex( $expected, $actual )`

Asserts that the given variable is a multidimensional array, and that all arrays
are non-empty:
* `assertNonEmptyMultidimensionalArray( $array )`

WordPress Query assertions (see above)
* `assertQueryTrue( ...$prop )`
* `assertQueriedObjectId( int $id )`
* `assertQueriedObject( $object )`

## Deprecated and Incorrect Usage Assertion

As with in `WP_UnitTestCase`, you can add phpdoc annotations to a test for
expected exceptions.

* `@expectedDeprecated` - Expects that the test will trigger a deprecation
  warning
* `@expectedIncorrectUsage` - Expects that `_doing_it_wrong()` will be called
  during the course of the test

## Cron / Queue Assertions
Cron and queue jobs can be asserted in unit tests.

### Cron
* `assertInCronQueue( string $action, array $args = [] )`
* `assertNotInCronQueue( string $action, array $args = [] )`
* `dispatch_cron( string $action = null )`

```php
$this->assertNotInCronQueue( 'example' );

wp_schedule_single_event( time(), 'example' );

$this->assertInCronQueue( 'example' );

$this->dispatch_cron( 'example' );
$this->assertNotInCronQueue( 'example' );
```

### Queue
* `assertJobQueued( $job, array $args = [], string $queue = null )`
* `assertJobNotQueued( $job, array $args = [], string $queue = null )`
* `dispatch_queue( string $queue = null )`

```php
$job = new Example_Job( 1, 2, 3 );

// Assert if a job class with a set of arguments is not in the queue.
$this->assertJobNotQueued( Example_Job::class, [ 1, 2, 3 ] );

// Assert if a specific job is not in the queue.
$this->assertJobNotQueued( $job );

Example_Job::dispatch( 1, 2, 3 );

$this->assertJobQueued( Example_Job::class, [ 1, 2, 3 ] );
$this->assertJobQueued( $job );

// Fire the queue.
$this->dispatch_queue();

$this->assertJobNotQueued( Example_Job::class, [ 1, 2, 3 ] );
$this->assertJobNotQueued( $job );
```

## Optional Traits

Mantle's Test Framework uses traits to add optional functionality to a test
case.

* `Refresh_Database` - Using this trait ensures that the database is rolled back
  after each test in the test case has run. Without it, data in the database
  will persist between tests, which almost certainly would not be desirable.
  That said, if your test case doesn't interact with the database, omitting this
  trait will provide a significant performance boost.
* `Admin_Screen` - Using this trait sets the current "screen" to a WordPress
  admin screen, and `is_admin()` will return true in tests in the test case
* `Network_Admin_Screen` - Same as with `Admin_Screen` except for the network
  admin and `is_network_admin()`
