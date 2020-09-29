# Testing Framework

- [Testing Framework](#testing-framework)
	- [Setup](#setup)
		- [Why This Instead of WordPress Core's Test Suite?](#why-this-instead-of-wordpress-cores-test-suite)
		- [Drop-in Support for Core Test Suite](#drop-in-support-for-core-test-suite)
	- [HTTP Requests and Responses](#http-requests-and-responses)
		- [Examples](#examples)
		- [Assertions](#assertions)
			- [HTTP Status Assertions](#http-status-assertions)
			- [Header Assertions](#header-assertions)
			- [Content Body Assertions](#content-body-assertions)
			- [WordPress Query Assertions](#wordpress-query-assertions)
			- [WordPress Existence Assertions](#wordpress-existence-assertions)
	- [Users](#users)
		- [Assertions](#assertions-1)
	- [Deprecated and Incorrect Usage Assertion](#deprecated-and-incorrect-usage-assertion)
	- [Cron / Queue Assertions](#cron--queue-assertions)
		- [Cron](#cron)
		- [Queue](#queue)
	- [Remote Request API Mock](#remote-request-api-mock)
		- [Faking All Requests](#faking-all-requests)
		- [Faking Multiple Endpoints](#faking-multiple-endpoints)
		- [Faking With a Callback](#faking-with-a-callback)
		- [Generating a Response](#generating-a-response)
		- [Asserting Requests](#asserting-requests)
	- [Optional Traits](#optional-traits)

Mantle provides a PHPUnit test framework to make it easier to test your code
with WordPress.

## Setup

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
Framework](https://github.com/alleyinteractive/mantle-framework/blob/main/src/mantle/framework/testing/wp-tests-config-sample.php)
to get started. This config is similar to `wp-config.php` and defines many of
the same constants. Most importantly, it defines the database information, which
*must* be different from your environment's database. If you reuse the same
database, your data could be lost!

The default configuration will install WordPress using a `localhost` database
named `wordpress_unit_tests` with the username/password pair of `root/root`. All
constants can be overridden using the `wp-tests-config.php` file or your unit
test's bootstrap file.

Lastly, see this repository's [`tests/bootstrap.php`
file](https://github.com/alleyinteractive/mantle-site/blob/main/tests/bootstrap.php)
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
The `Mantle\Framework\Testing\Framework_Test_Case` class should be extended from
for any non-Mantle based project. For more information, see [Transitioning to
Test Framework](./1-transition.md).

## HTTP Requests and Responses

Mantle provides a fluent HTTP Request interface to make it easier to write
feature/integration tests using PHPUnit and WordPress. This library is a
derivative work of Laravel's testing framework, customized to work with
WordPress. In short, this library allows one to mimic a request to WordPress,
and it sets up WordPress' global state as if it were handling that request (e.g.
sets up superglobals and other WordPress-specific globals, sets up and executes
the main query, loads the appropriate template file, etc.). It then creates a
new `Test_Response` object which stores the details of the HTTP response,
including headers and body content. The response object allows the developer to
make assertions against the observable response data, for instance asserting
that some content is present in the response body or that some header was set.

Request methods are HTTP verbs, `get()`, `post()`, `put()`, etc.

### Examples

As a basic example, here we create a post via its factory, then request it and
assert we see the post's name (title):

```php
$post = factory( Post::class )->create();
$this->get( $post )
     ->assertSee( $post->name() );
```

In this example, here we request a non-existing resource and assert that it
yields a 404 Not Found response:

```php
$this->get( '/this/resource/does/not/exist/' )
     ->assertNotFound();
```

Lastly, here's an example of POSTing some data to an endpoint, and after
following a redirect, asserting that it sees a success message:

```php
$this->following_redirects()
     ->post( '/profile/', [ 'some_data' => 'hello' ] )
     ->assertSee( 'Success!' );
```

### Assertions

`Test_Response` provides many assertions to confirm aspects of the response
return as expected.

#### HTTP Status Assertions

* `assertSuccessful()` - Assert 2xx
* `assertOk()` - Assert 200
* `assertStatus( $status )`
* `assertCreated()` - Assert 201
* `assertNoContent( $status = 204 )`
* `assertNotFound()` - Assert 404
* `assertForbidden()` - Assert 403
* `assertUnauthorized()` - Assert 401
* `assertRedirect( $uri = null )` - Asserts that the response is 301 or 302, and
  also runs `assertLocation()` with the `$uri`

#### Header Assertions

* `assertLocation( $uri )`
* `assertHeader( $header_name, $value = null )`
* `assertHeaderMissing( $header_name )`

#### Content Body Assertions

* `assertSee( $value )` - Assert the given string exists in the body content
* `assertSeeInOrder( array $values )` - Assert the given strings exist in the
  body content in the given order
* `assertSeeText( $value )` - Similar to `assertSee()` but strips all HTML tags
  first
* `assertSeeTextInOrder( array $values )` - Similar to `assertSeeInOrder()` but
  strips all HTML tags first
* `assertDontSee( $value )`
* `assertDontSeeText( $value )`

#### WordPress Query Assertions

* `assertQueryTrue( ...$prop )` - Assert the given WP_Query `is_` functions
  (`is_single()`, `is_archive()`, etc.) return true and all others return false
* `assertQueriedObjectId( int $id )` - Assert the given ID matches the result of
  `get_queried_object_id()`
* `assertQueriedObject( $object )` - Assert that the type and ID of the given
  object match that of `get_queried_object()`


#### WordPress Existence Assertions

* `assertPostExists( array $args )` - Assert if a post exists given a set of
  arguments.
* `assertPostDoesNotExists( array $args )` - Assert if a post doesn't exists
  given a set of arguments.
* `assertTermExists( array $args )` - Assert if a term exists given a set of
  arguments.
* `assertTermDoesNotExists( array $args )` - Assert if a term doesn't exists
  given a set of arguments.
* `assertUserExists( array $args )` - Assert if a user exists given a set of
  arguments.
* `assertUserDoesNotExists( array $args )` - Assert if a user doesn't exists
  given a set of arguments.

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

## Remote Request API Mock
Remote request mocks are a very common use case to test against when unit
testing. Mantle gives you the ability to mock specific requests and fluently
generate a response.

### Faking All Requests
```php
$this->fake_request()
  ->with_response_code( 404 )
  ->with_body( 'test body' );
```

### Faking Multiple Endpoints
Faking a specific endpoint, `testing.com` will return a 404 while `github.com`
will return a 500.

```php
$this->fake_request( 'https://testing.com/*' )
  ->with_response_code( 404 )
  ->with_body( 'test body' );

$this->fake_request( 'https://github.com/*' )
  ->with_response_code( 500 )
  ->with_body( 'fake body' );
```

You can also pass an array with a set of responses (or a callback):

```php
use Mantle\Framework\Testing\Mock_Http_Response;
$this->fake_request(
  [
    'https://github.com/*'  => Mock_Http_Response::create()->with_body( 'github' ),
    'https://twitter.com/*' => Mock_Http_Response::create()->with_body( 'twitter' ),
  ]
);
```

### Faking With a Callback
```php
$this->fake_request(
  function( string $url, array $request_args ) {
    if ( false === strpos( $url, 'alley.co' ) ) {
      return;
    }

    return Mock_Http_Response::create()
      ->with_response_code( 123 )
      ->with_body( 'alley!' );
  }
);
```

### Generating a Response
`Mantle\Framework\Testing\Mock_Http_Response` exists to help you fluently build
a WordPress-style remote response.

```php
use Mantle\Framework\Testing\Mock_Http_Response;

// 404 response.
Mock_Http_Response::create()
  ->with_response_code( 404 )
  ->with_body( 'test body' );

// JSON response.
Mock_Http_Response::create()
  ->with_json( [ 1, 2, 3 ] );

// Redirect response.
Mock_Http_Response::create()
  ->with_redirect( 'https://wordpress.org/' );
```

### Asserting Requests
All remote requests can be asserted against, even if they're not being faked by
the test case. Mantle will log if an actual remote request is being made
during an unit test.

```php
$this->assertRequestSent( 'https://alley.co/' );
$this->assertRequestNotSent( 'https://anothersite.com/' );
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
