# Test Framework

Mantle provides a PHPUnit test framework to make it easier to test your code with WordPress.

## Setup

Mantle's Test Framework provides a special bootstrapper and installer for WordPress. It is common in WordPress to use a _separate_ WordPress
codebase when running unit tests. In Mantle, you use the same codebase and a separate database. As long as your test suite isn't writing to any
files, a singular codebase is a preferable setup, especially if you want to use xdebug to step through your test.

The Mantle Test Framework expects a test config in your WordPress root directory, named `wp-tests-config.php`. See [the sample config in the Mantle Framework](https://github.com/alleyinteractive/mantle-framework/blob/main/src/mantle/framework/testing/wp-tests-config-sample.php)
to get started. This config is similar to `wp-config.php` and defines many of the same constants. Most importantly, it defines the database
information, which *must* be different from your environment's database. If you reuse the same database, your data could be lost!

Lastly, see this repository's [`tests/bootstrap.php` file](https://github.com/alleyinteractive/mantle-site/blob/main/tests/bootstrap.php) for
examples of how to load the Mantle Test Framework in your project.

### Why This Instead of WordPress Core's Test Suite?

We hope nobody interprets Mantle's Test Framework as a slight against WordPress Core's test suite. We :heart: WordPress Core's test suite and
Mantle's Test Framework is unequivocally a derivative work of it.

WordPress Core's test suite ("wordpress-develop", if you will) is a wonderful test suite for testing WordPress itself. We, and many others in
the WordPress community, have been repurposing it for years to help us run plugin and theme tests. That's worked fine, but it's not optimal.
Mantle's Test Framework tries to incorporate the best parts of WordPress Core's test suite, but remove the unnecessary bits. Without having
to worry about older versions of PHP, that also allows Mantle's Test Framework to use the latest versions of PHPUnit itself.

## HTTP Requests and Responses

Mantle provides a fluent HTTP Request interface to make it easier to write feature/integration tests using PHPUnit and WordPress. This library
is a derivative work of Laravel's testing framework, customized to work with WordPress. In short, this library allows one to mimic a request to
WordPress, and it sets up WordPress' global state as if it were handling that request (e.g. sets up superglobals and other WordPress-specific
globals, sets up and executes the main query, loads the appropriate template file, etc.). It then creates a new `Test_Response` object which
stores the details of the HTTP response, including headers and body content. The response object allows the developer to make assertions
against the observable response data, for instance asserting that some content is present in the response body or that some header was set.

Request methods are HTTP verbs, `get()`, `post()`, `put()`, etc.

### Examples

As a basic example, here we create a post via its factory, then request it and assert we see the post's name (title):

```php
$post = factory( Post::class )->create();
$this->get( $post )
     ->assertSee( $post->name() );
```

In this example, here we request a non-existing resource and assert that it yields a 404 Not Found response:

```php
$this->get( '/this/resource/does/not/exist/' )
     ->assertNotFound();
```

Lastly, here's an example of POSTing some data to an endpoint, and after following a redirect, asserting that it sees a success message:

```php
$this->following_redirects()
     ->post( '/profile/', [ 'some_data' => 'hello' ] )
     ->assertSee( 'Success!' );
```

### Assertions

`Test_Response` provides many assertions to confirm aspects of the response return as expected.

#### HTTP Status Assertions

* `assertSuccessful()` - Assert 2xx
* `assertOk()` - Assert 200
* `assertStatus( $status )`
* `assertCreated()` - Assert 201
* `assertNoContent( $status = 204 )`
* `assertNotFound()` - Assert 404
* `assertForbidden()` - Assert 403
* `assertUnauthorized()` - Assert 401
* `assertRedirect( $uri = null )` - Asserts that the response is 301 or 302, and also runs `assertLocation()` with the `$uri`

#### Header Assertions

* `assertLocation( $uri )`
* `assertHeader( $header_name, $value = null )`
* `assertHeaderMissing( $header_name )`

#### Content Body Assertions

* `assertSee( $value )` - Assert the given string exists in the body content
* `assertSeeInOrder( array $values )` - Assert the given strings exist in the body content in the given order
* `assertSeeText( $value )` - Similar to `assertSee()` but strips all HTML tags first
* `assertSeeTextInOrder( array $values )` - Similar to `assertSeeInOrder()` but strips all HTML tags first
* `assertDontSee( $value )`
* `assertDontSeeText( $value )`

#### WordPress Query Assertions

* `assertQueryTrue( ...$prop )` - Assert the given WP_Query `is_` functions (`is_single()`, `is_archive()`, etc.) return true and all others return false
* `assertQueriedObjectId( int $id )` - Assert the given ID matches the result of `get_queried_object_id()`
* `assertQueriedObject( $object )` - Assert that the type and ID of the given object match that of `get_queried_object()`

## Users

The Mantle Test Framework provides a method, `acting_as( $user )` to execute a test as a given user or a user in the given role. This is best
explained through code, so here are some examples of using this method:

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

## Assertions

Mantle's Test Case provides some assertions above and beyond PHPUnit's, largely influenced by `WP_UnitTestCase`. Here's a runthrough.

Assert the given item is/is not a `WP_Error`:
* `assertWPError( $actual, $message = '' )`
* `assertNotWPError( $actual, $message = '' )`

Asserts that the given fields are present in the given object:
* `assertEqualFields( $object, $fields )`

Asserts that two values are equal, with whitespace differences discarded:
* `assertDiscardWhitespace( $expected, $actual )`

Asserts that two values are equal, with EOL differences discarded:
* `assertEqualsIgnoreEOL( $expected, $actual )`

Asserts that the contents of two un-keyed, single arrays are equal, without accounting for the order of elements:
* `assertEqualSets( $expected, $actual )`

Asserts that the contents of two keyed, single arrays are equal, without accounting for the order of elements:
* `assertEqualSetsWithIndex( $expected, $actual )`

Asserts that the given variable is a multidimensional array, and that all arrays are non-empty:
* `assertNonEmptyMultidimensionalArray( $array )`

WordPress Query assertions (see above)
* `assertQueryTrue( ...$prop )`
* `assertQueriedObjectId( int $id )`
* `assertQueriedObject( $object )`

### Post Conditions

As with in `WP_UnitTestCase`, you can add phpdoc annotations to a test for expected exceptions.

* `@expectedDeprecated` - Expects that the test will trigger a deprecation warning
* `@expectedIncorrectUsage` - Expects that `_doing_it_wrong()` will be called during the course of the test

## Optional Traits

Mantle's Test Framework uses traits to add optional functionality to a test case.

* `Refresh_Database` - Using this trait ensures that the database is rolled back after each test in the test case has run. Without it, data in the database will persist between tests, which almost certainly would not be desirable. That said, if your test case doesn't interact with the database, omitting this trait will provide a significant performance boost.
* `Admin_Screen` - Using this trait sets the current "screen" to a WordPress admin screen, and `is_admin()` will return true in tests in the test case
* `Network_Admin_Screen` - Same as with `Admin_Screen` except for the network admin and `is_network_admin()`
