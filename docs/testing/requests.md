# HTTP Requests

[[toc]]

## Introduction

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

## Examples

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

## Assertions

`Test_Response` provides many assertions to confirm aspects of the response
return as expected.

### HTTP Status Assertions

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

### Header Assertions

* `assertLocation( $uri )`
* `assertHeader( $header_name, $value = null )`
* `assertHeaderMissing( $header_name )`

### Content Body Assertions

* `assertSee( $value )` - Assert the given string exists in the body content
* `assertSeeInOrder( array $values )` - Assert the given strings exist in the
  body content in the given order
* `assertSeeText( $value )` - Similar to `assertSee()` but strips all HTML tags
  first
* `assertSeeTextInOrder( array $values )` - Similar to `assertSeeInOrder()` but
  strips all HTML tags first
* `assertDontSee( $value )`
* `assertDontSeeText( $value )`

### WordPress Query Assertions

* `assertQueryTrue( ...$prop )` - Assert the given WP_Query `is_` functions
  (`is_single()`, `is_archive()`, etc.) return true and all others return false
* `assertQueriedObjectId( int $id )` - Assert the given ID matches the result of
  `get_queried_object_id()`
* `assertQueriedObject( $object )` - Assert that the type and ID of the given
  object match that of `get_queried_object()`


### WordPress Existence Assertions

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
