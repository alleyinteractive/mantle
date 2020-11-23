# Remote Requests

[[toc]]

## Introduction

Remote request mocks are a very common use case to test against when unit
testing. Mantle gives you the ability to mock specific requests and fluently
generate a response.

## Faking All Requests

Intercept all remote requests with a specified response code and body.

```php
$this->fake_request()
  ->with_response_code( 404 )
  ->with_body( 'test body' );
```

## Faking Multiple Endpoints

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

## Faking With a Callback

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

## Generating a Response

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

## Asserting Requests

All remote requests can be asserted against, even if they're not being faked by
the test case. Mantle will log if an actual remote request is being made
during a unit test.

```php
$this->assertRequestSent( 'https://alley.co/' );
$this->assertRequestNotSent( 'https://anothersite.com/' );
```
