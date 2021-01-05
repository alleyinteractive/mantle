# Browser Testing

[[toc]]

## Introduction

Mantle Browser Testing is a port of Laravel's Dusk package to the Mantle Testing
framework. It provides an expressive and easy-to-use browser testing library. By
default, Mantle Browser Testing does not require you to install JDK or Selenium
on your local computer. Instead, it uses a standalone
[ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/home)
installation. However, you are free to utilize any other Selenium compatible
driver you wish.

::: details Credits Where Due
Most of the credits for this package go to the [authors of
Dusk](https://github.com/laravel/dusk/graphs/contributors) and we are thankful
to have it as apart of our framework!
:::

## Installation

To get started, you should add the `alleyinteractive/mantle-browser-testing`
Composer dependency to your project:

```bash
composer require --dev alleyinteractive/mantle-browser-testing
```

::: details Loading the Service Provider
Through package discovery, the browser testing service provider should
automatically be loaded to your application. If it is not, add
`Mantle\Browser_Testing\Browser_Testing_Service_Provider::class` to your
application's service provider configuration.
:::

::: tip If you are manually registering the Mantle Browser testing service
provider: You should **never** register it in your production environment, as
doing so could lead to arbitrary users being able to authenticate with your
application.
:::

After installing the package, execute the `mantle browser-testing:install`
`wp-cli` command. The installation command will create a `tests/browser`
directory and an example browser test:

```bash
wp mantle browser-testing:install
```


### Configuration

Next, add a new config file to your `config/` folder with the following
contents:

```php
<?php
/**
 * Browser Testing Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Browser Testing URL
	|--------------------------------------------------------------------------
	|
	| Here you can specify the URL to use for browser testing. When running test
	| via PHPUnit, example.org will be used by default. Browser testing requires
	| an actual endpoint to hit and test against. The URL is assumed to be a real
	| and browseable site that Chrome can visit.
	|
	*/
	'url' => 'https://example.org',
];

```

Change the `url` configuration value to your website URL that can be browser
tested against. This value should match the URL you use to access your
application in a browser.

### Managing ChromeDriver Installations

If you would like to install a different version of ChromeDriver than what is
included with Mantle Browser Testing, you may use the `mantle
browser-testing:chrome-driver` command:

```bash
# Install the latest version of ChromeDriver for your OS...
wp mantle browser-testing:chrome-driver

# Install a given version of ChromeDriver for your OS...
wp mantle browser-testing:chrome-driver 86

# Install a given version of ChromeDriver for all supported OSs...
wp mantle browser-testing:chrome-driver --all

# Install the version of ChromeDriver that matches the detected version of Chrome / Chromium for your OS...
wp mantle browser-testing:chrome-driver --detect
```

::: tip The package requires the `chromedriver` binaries to be executable.

If you're having problems running browser testing, you should ensure the
binaries are executable using the following command: `chmod -R 0755
vendor/alleyinteractive/mantle-browser-testing/bin/`.
:::

### Using Other Browsers

By default, browser testing uses Google Chrome and a standalone
[ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/home)
installation to run your browser tests. However, you may start your own Selenium
server and run your tests against any browser you wish.

To get started, open your `tests/browser/class-browser-test-case.php` file,
which is the base browser-testing test case for your application. Within this
file, you can remove the call to the `start_chrome_driver` method. This will stop
testing from automatically starting the ChromeDriver:

```php
/**
 * Prepare for test execution.
 *
 * @beforeClass
 * @return void
 */
public static function prepare() {
    // static::start_chrome_driver();
}
```

Next, you may modify the `driver` method to connect to the URL and port of your
choice. In addition, you may modify the "desired capabilities" that should be
passed to the WebDriver:

```php
/**
 * Create the RemoteWebDriver instance.
 *
 * @return RemoteWebDriver
 */
protected function driver(): RemoteWebDriver {
  return RemoteWebDriver::create(
    'http://localhost:4444/wd/hub', DesiredCapabilities::phantomjs()
  );
}
```

## Getting Started

### Generating Tests

To generate a Browser Testing test, use the `mantle browser-testing:make` command. The generated test
will be placed in the `tests/browser` directory:

```bash
wp mantle browser-testing:make Test_Login
```


### Database Migrations

Most of the tests you write will interact with pages that retrieve data from
your application's database; however, your browser tests should never use the
`RefreshDatabase `trait. The `RefreshDatabase` trait leverages database
transactions which will not be applicable or available across HTTP requests.

### Running Tests

You can run your tests as apart of your normal PHPUnit application tests. If you
are running this in a continuous integration environment such as GitHub Actions,
Travis CI, you will need to setup a web server to test against.

```bash
composer run phpunit
```

#### Manually Starting ChromeDriver

By default, Mantle Browser Testing will automatically attempt to start
ChromeDriver. If this does not work for your particular system, you may manually
start ChromeDriver before running the `phpunit` command. If you choose to start
ChromeDriver manually, you should comment out the following line of your
`tests/browser/class-browser-test-case.php` file:

```php
/**
 * Prepare for test execution.
 *
 * @beforeClass
 * @return void
 */
public static function prepare() {
    // static::start_chrome_driver();
}
```

In addition, if you start ChromeDriver on a port other than `9515`, you should
modify the `driver` method of the same class to reflect the correct port:

```php
/**
 * Create the RemoteWebDriver instance.
 *
 * @return RemoteWebDriver
 */
protected function driver(): RemoteWebDriver {
  return RemoteWebDriver::create(
    'http://localhost:9515', DesiredCapabilities::chrome()
  );
}
```

## Browser Basics

### Creating Browsers

To get started, let's write a test that verifies we can log into our
application. After generating a test, we can modify it to navigate to the login
page, enter some credentials, and click the "Login" button. To create a browser
instance, you may call the `browse` method from within your browser test:

```php
<?php

namespace App\Tests\Browser;

use App\Models\User;
use App\Tests\Browser\Browser_Test_Case;

class Test_Example extends Browser_Test_Case {
  /**
   * A basic browser test example.
   *
   * @return void
   */
  public function test_basic_example() {
    $user = factory( User::class )->create([
        'email' => 'taylor@laravel.com',
    ]);

    $this->browse( function (  $browser  ) use ( $user ) {
      $browser->visit( '/login' )
        ->type( 'email', $user->email )
        ->type( 'password', 'password' )
        ->press( 'Login' )
        ->assertPathIs( '/home' );
    } );
  }
}
```

As you can see in the example above, the `browse` method accepts a closure. A
browser instance will automatically be passed to this closure by the browser
testing package and is the main object used to interact with and make assertions
against your application.

#### Creating Multiple Browsers

Sometimes you may need multiple browsers in order to properly carry out a test.
For example, multiple browsers may be needed to test a chat screen that
interacts with websockets. To create multiple browsers, simply add more browser
arguments to the signature of the closure given to the `browse` method:

```php
$this->browse( function (  $first, $second  ) {
	$first->loginAs( User::find( 1 ) )
		->visit( '/home' )
		->waitForText( 'Message' );

	$second->loginAs( User::find( 2 ) )
		->visit( '/home' )
		->waitForText( 'Message' )
		->type( 'message', 'Hey Taylor' )
		->press( 'Send' );

	$first->waitForText( 'Hey Taylor' )
		->assertSee( 'Jeffrey Way' );
} );
```

### Navigation

The `visit` method may be used to navigate to a given URI within your
application:

```php
$browser->visit( '/login' );
```

You may use the `visit_route` method to navigate to a named route:

```php
$browser->visit_route( 'login' );
```

You may navigate "back" and "forward" using the `back` and `forward` methods:

```php
$browser->back();

$browser->forward();
```

You may use the `refresh` method to refresh the page:

```php
$browser->refresh();
```

### Resizing Browser Windows

You may use the `resize` method to adjust the size of the browser window:

```php
$browser->resize( 1920, 1080 );
```

The `maximize` method may be used to maximize the browser window:

```php
$browser->maximize();
```

The `fit_content` method will resize the browser window to match the size of its
content:

```php
$browser->fit_content();
```

When a test fails, the library will automatically resize the browser to fit the content
prior to taking a screenshot. You may disable this feature by calling the
`disable_fit_on_failure` method within your test:

```php
$browser->disable_fit_on_failure();
```

You may use the `move` method to move the browser window to a different position
on your screen:

```php
$browser->move( $x = 100, $y = 100 );
```

### Browser Macros

If you would like to define a custom browser method that you can re-use in a
variety of your tests, you may use the `macro` method on the `Browser` class.
Typically, you should call this method from a service provider's `boot` method:

```php
<?php

namespace App\Providers;

use Mantle\Framework\Support\Service_Provider;
use Mantle\Browser_Testing\Browser;

class Browser_Testing_Service_Provider extends Service_Provider {
	/**
	 * Register Browser Testing's browser macros.
	 *
	 * @return void
	 */
	public function boot() {
		parent::boot();

		Browser::macro( 'scrollToElement', function ( $element = null ) {
			$this->script("$('html, body').animate({ scrollTop: $('$element').offset().top }, 0);");

			return $this;
		} );
	}
}
```

The `macro` function accepts a name as its first argument, and a closure as its
second. The macro's closure will be executed when calling the macro as a method
on a `Browser` instance:

```php
$this->browse( function (  $browser  ) use (  $user  ) {
    $browser->visit('/pay')
      ->scrollToElement('#credit-card-details')
      ->assertSee('Enter Credit Card Details');
} );
```

### Authentication

Often, you will be testing pages that require authentication. You can use the
`login_as` method in order to avoid interacting with your application's login
screen during every test. The `login_as` method accepts a primary key associated
with your authenticatable model or an authenticatable model instance:

```php
use App\Models\User;

$this->browse(function (  $browser  ) {
  $browser->login_as( User::find( 1 ) )->visit('/home');
} );
```

> After using the `login_as` method, the user session will be maintained
> for all tests within the file.

### Cookies

You may use the `cookie` method to get or set an encrypted cookie's value.

```php
$browser->cookie( 'name' );

$browser->cookie( 'name', 'Taylor' );
```

You may use the `delete_cookie` method to delete the given cookie:

```php
$browser->delete_cookie('name');
```

### Executing JavaScript

You may use the `script` method to execute arbitrary JavaScript statements
within the browser:

```php
$output = $browser->script( 'document.documentElement.scrollTop = 0' );

$output = $browser->script( [
    'document.body.scrollTop = 0',
    'document.documentElement.scrollTop = 0',
] );
```

### Taking A Screenshot

You may use the `screenshot` method to take a screenshot and store it with the
given filename. All screenshots will be stored within the
`tests/browser/screenshots` directory:

```php
$browser->screenshot( 'filename' );
```

### Storing Console Output To Disk

You may use the `store_console_log` method to write the current browser's console
output to disk with the given filename. Console output will be stored within the
`tests/browser/console` directory:

```php
$browser->store_console_log( 'filename' );
```


### Storing Page Source To Disk

You may use the `storeSource` method to write the current page's source to disk
with the given filename. The page source will be stored within the
`tests/Browser/source` directory:

```php
$browser->store_source( 'filename' );
```


## Interacting With Elements

### Text, Values, & Attributes

#### Retrieving & Setting Values

Mantle Browser Testing provides several methods for interacting with the current
display text, value, and attributes of elements on the page. For example, to get
the "value" of an element that matches a given CSS selector, use the `value`
method:

```php
// Retrieve the value...
$value = $browser->value('selector');

// Set the value...
$browser->value('selector', 'value');
```

You may use the `input_value` method to get the "value" of an input element that
has a given field name:

```php
$value = $browser->input_value('field');
```

#### Retrieving Text

The `text` method may be used to retrieve the display text of an element that
matches the given selector:

```php
$text = $browser->text( 'selector' );
```

#### Retrieving Attributes

Finally, the `attribute` method may be used to retrieve the value of an
attribute of an element matching the given selector:

```php
$attribute = $browser->attribute( 'selector', 'value' );
```

### Interacting With Forms

#### Typing Values

Mantle Browser Testing provides a variety of methods for interacting with forms
and input elements. First, let's take a look at an example of typing text into
an input field:

```php
$browser->type( 'email', 'info@alley.co' );
```

Note that, although the method accepts one if necessary, we are not required to
pass a CSS selector into the `type` method. If a CSS selector is not provided,
The library will search for an `input` or `textarea` field with the given `name`
attribute.

To append text to a field without clearing its content, you may use the `append`
method:

```php
$browser->type( 'tags', 'foo' )
  ->append( 'tags', ', bar, baz' );
```

You may clear the value of an input using the `clear` method:

```php
$browser->clear( 'email' );
```

You can instruct the test to type slowly using the `typeSlowly` method. By
default, it will pause for 100 milliseconds between key presses. To customize
the amount of time between key presses, you may pass the appropriate number of
milliseconds as the third argument to the method:

    $browser->typeSlowly( 'mobile', '+1 (202) 555-5555' );

    $browser->typeSlowly( 'mobile', '+1 (202) 555-5555', 300 );

You may use the `appendSlowly` method to append text slowly:

    $browser->type( 'tags', 'foo' )
      ->appendSlowly( 'tags', ', bar, baz' );


#### Dropdowns

To select a value available on a `select` element, you may use the `select`
method. Like the `type` method, the `select` method does not require a full CSS
selector. When passing a value to the `select` method, you should pass the
underlying option value instead of the display text:

    $browser->select( 'size', 'Large' );

You may select a random option by omitting the second argument:

    $browser->select( 'size' );


#### Checkboxes

To "check" a checkbox input, you may use the `check` method. Like many other
input related methods, a full CSS selector is not required. If a CSS selector
match can't be found, the test will search for a checkbox with a matching `name`
attribute:

    $browser->check( 'terms' );

The `uncheck` method may be used to "uncheck" a checkbox input:

    $browser->uncheck( 'terms' );


#### Radio Buttons

To "select" a `radio` input option, you may use the `radio` method. Like many
other input related methods, a full CSS selector is not required. If a CSS
selector match can't be found, the test will search for a `radio` input with
matching `name` and `value` attributes:

    $browser->radio( 'size', 'large' );


### Attaching Files

The `attach` method may be used to attach a file to a `file` input element. Like
many other input related methods, a full CSS selector is not required. If a CSS
selector match can't be found, the test will search for a `file` input with a
matching `name` attribute:

    $browser->attach( 'photo', __DIR__ . '/photos/mountains.png' );

> The attach function requires the `Zip` PHP extension to be installed
> and enabled on your server.

### Pressing Buttons

The `press` method may be used to click a button element on the page. The first
argument given to the `press` method may be either the display text of the
button or a CSS selector:

    $browser->press( 'Login' );

When submitting forms, many application's disable the form's submission button
after it are pressed and then re-enable the button when the form submission's
HTTP request is complete. To press a button and wait for the button to be
re-enabled, you may use the `pressAndWaitFor` method:

    // Press the button and wait a maximum of 5 seconds for it to be enabled...
    $browser->pressAndWaitFor( 'Save' );

    // Press the button and wait a maximum of 1 second for it to be enabled...
    $browser->pressAndWaitFor( 'Save', 1 );


### Clicking Links

To click a link, you may use the `clickLink` method on the browser instance. The
`clickLink` method will click the link that has the given display text:

    $browser->clickLink( $link_text );

You may use the `seeLink` method to determine if a link with the given display
text is visible on the page:

    if ( $browser->seeLink( $link_text ) ) {
        // ...
    }

> These methods interact with jQuery. If jQuery is not available on the
> page, Mantle Browser Testing will automatically inject it into the page so it is available for
> the test's duration.

### Using The Keyboard

The `keys` method allows you to provide more complex input sequences to a given
element than normally allowed by the `type` method. For example, you may
instruct the test to hold modifier keys while entering values. In this example, the
`shift` key will be held while `taylor` is entered into the element matching the
given selector. After `taylor` is typed, `swift` will be typed without any
modifier keys:

    $browser->keys( 'selector', ['{shift}', 'taylor'], 'swift' );

Another valuable use case for the `keys` method is sending a "keyboard shortcut"
combination to the primary CSS selector for your application:

    $browser->keys( '.app', ['{command}', 'j'] );

::: tip
All modifier keys such as `{command}` are wrapped in `{}` characters,
and match the constants defined in the `Facebook\WebDriver\WebDriverKeys` class,
which can be [found on
GitHub](https://github.com/php-webdriver/php-webdriver/blob/master/lib/WebDriverKeys.php).
:::

### Using The Mouse

#### Clicking On Elements

The `click` method may be used to click on an element matching the given CSS:

    $browser->click( '.selector' );

The `clickAtXPath` method may be used to click on an element matching the given
XPath expression:

    $browser->clickAtXPath( '//div[@class = "selector"]' );

The `clickAtPoint` method may be used to click on the topmost element at a given
pair of coordinates relative to the viewable area of the browser:

    $browser->clickAtPoint( $x = 0, $y = 0 );

The `doubleClick` method may be used to simulate the double click of a mouse:

    $browser->doubleClick();

The `rightClick` method may be used to simulate the right click of a mouse:

    $browser->rightClick();

    $browser->rightClick( '.selector' );

The `clickAndHold` method may be used to simulate a mouse button being clicked
and held down. A subsequent call to the `releaseMouse` method will undo this
behavior and release the mouse button:

    $browser->clickAndHold()
      ->pause(1000)
      ->releaseMouse();


#### Mouseover

The `mouseover` method may be used when you need to move the mouse over an
element matching the given CSS selector:

    $browser->mouseover( '.selector' );


#### Drag & Drop

The `drag` method may be used to drag an element matching the given selector to
another element:

    $browser->drag( '.from-selector', '.to-selector' );

Or, you may drag an element in a single direction:

    $browser->dragLeft( '.selector', $pixels = 10 );
    $browser->dragRight( '.selector', $pixels = 10 );
    $browser->dragUp( '.selector', $pixels = 10 );
    $browser->dragDown( '.selector', $pixels = 10 );

Finally, you may drag an element by a given offset:

    $browser->dragOffset( '.selector', $x = 10, $y = 10 );


### JavaScript Dialogs

Mantle Browser Testing provides various methods to interact with JavaScript
Dialogs. For example, you may use the `waitForDialog` method to wait for a
JavaScript dialog to appear. This method accepts an optional argument indicating
how many seconds to wait for the dialog to appear:

    $browser->waitForDialog( $seconds = null );

The `assertDialogOpened` method may be used to assert that a dialog has been
displayed and contains the given message:

    $browser->assertDialogOpened( 'Dialog message' );

If the JavaScript dialog contains a prompt, you may use the `typeInDialog`
method to type a value into the prompt:

    $browser->typeInDialog( 'Hello World' );

To close an open JavaScript dialog by clicking the "OK" button, you may invoke
the `acceptDialog` method:

    $browser->acceptDialog();

To close an open JavaScript dialog by clicking the "Cancel" button, you may
invoke the `dismissDialog` method:

    $browser->dismissDialog();


### Scoping Selectors

Sometimes you may wish to perform several operations while scoping all of the
operations within a given selector. For example, you may wish to assert that
some text exists only within a table and then click a button within that table.
You may use the `with` method to accomplish this. All operations performed
within the closure given to the `with` method will be scoped to the original
selector:

    $browser->with( '.table', function (  $table  ) {
        $table->assertSee('Hello World')
              ->clickLink('Delete');
    } );

You may occasionally need to execute assertions outside of the current scope.
You may use the `elsewhere` and `elsewhereWhenAvailable` methods to accomplish
this:

     $browser->with( '.table', function (  $table  ) {
        // Current scope is `body .table`...

        $browser->elsewhere( '.page-title', function (  $title  ) {
            // Current scope is `body .page-title`...
            $title->assertSee( 'Hello World' );
        } );

        $browser->elsewhereWhenAvailable( '.page-title', function (  $title  ) {
            // Current scope is `body .page-title`...
            $title->assertSee( 'Hello World' );
        } );
     } );

### Waiting For Elements

When testing applications that use JavaScript extensively, it often becomes
necessary to "wait" for certain elements or data to be available before
proceeding with a test. Browser Testing makes this a cinch. Using a variety of methods, you
may wait for elements to be visible on the page or even wait until a given
JavaScript expression evaluates to `true`.

#### Waiting

If you just need to pause the test for a given number of milliseconds, use the
`pause` method:

```php
$browser->pause( 1000 );
```

#### Waiting For Selectors

The `waitFor` method may be used to pause the execution of the test until the
element matching the given CSS is displayed on the page. By
default, this will pause the test for a maximum of five seconds before throwing
an exception. If necessary, you may pass a custom timeout threshold as the
second argument to the method:

```php
// Wait a maximum of five seconds for the selector...
$browser->waitFor( '.selector' );

// Wait a maximum of one second for the selector...
$browser->waitFor( '.selector', 1 );
```

You may also wait until the element matching the given selector contains the
given text:

```php
// Wait a maximum of five seconds for the selector to contain the given text...
$browser->waitForTextIn( '.selector', 'Hello World' );

// Wait a maximum of one second for the selector to contain the given text...
$browser->waitForTextIn( '.selector', 'Hello World', 1 );
```

You may also wait until the element matching the given selector is missing from
the page:

```php
// Wait a maximum of five seconds until the selector is missing...
$browser->waitUntilMissing( '.selector' );

// Wait a maximum of one second until the selector is missing...
$browser->waitUntilMissing( '.selector', 1 );
```

#### Scoping Selectors When Available

Occasionally, you may wish to wait for an element to appear that matches a given
selector and then interact with the element. For example, you may wish to wait
until a modal window is available and then press the "OK" button within the
modal. The `whenAvailable` method may be used to accomplish this. All element
operations performed within the given closure will be scoped to the original
selector:

```php
$browser->whenAvailable( '.modal', function (  $modal  ) {
    $modal->assertSee( 'Hello World' )
          ->press( 'OK' );
} );
```


#### Waiting For Text

The `waitForText` method may be used to wait until the given text is displayed
on the page:

```php
// Wait a maximum of five seconds for the text...
$browser->waitForText('Hello World');

// Wait a maximum of one second for the text...
$browser->waitForText('Hello World', 1);
```

You may use the `waitUntilMissingText` method to wait until the displayed text
has been removed from the page:

```php
// Wait a maximum of five seconds for the text to be removed...
$browser->waitUntilMissingText( 'Hello World' );

// Wait a maximum of one second for the text to be removed...
$browser->waitUntilMissingText( 'Hello World', 1 );
```

#### Waiting For Links

The `waitForLink` method may be used to wait until the given link text is
displayed on the page:

```php
// Wait a maximum of five seconds for the link...
$browser->waitForLink( 'Create' );

// Wait a maximum of one second for the link...
$browser->waitForLink( 'Create', 1 );
```


#### Waiting On The Page Location

When making a path assertion such as `$browser->assertPathIs('/home')`, the
assertion can fail if `window.location.pathname` is being updated
asynchronously. You may use the `waitForLocation` method to wait for the
location to be a given value:

```php
$browser->waitForLocation( '/secret' );
```

You may also wait for a [named route's](/docs/{{version}}/routing#named-routes)
location:

```php
$browser->waitForRoute(  $routeName, $parameters  );
```

#### Waiting for Page Reloads

If you need to make assertions after a page has been reloaded, use the
`waitForReload` method:

```php
$browser->click('.some-action')
	->waitForReload()
	->assertSee('something');
```


#### Waiting On JavaScript Expressions

Sometimes you may wish to pause the execution of a test until a given JavaScript
expression evaluates to `true`. You may easily accomplish this using the
`waitUntil` method. When passing an expression to this method, you do not need
to include the `return` keyword or an ending semi-colon:

    // Wait a maximum of five seconds for the expression to be true...
    $browser->waitUntil( 'App.data.servers.length > 0' );

    // Wait a maximum of one second for the expression to be true...
    $browser->waitUntil( 'App.data.servers.length > 0', 1 );

#### Waiting With A Callback

Many of the "wait" methods in browser testing rely on the underlying `waitUsing` method.
You may use this method directly to wait for a given closure to return `true`.
The `waitUsing` method accepts the maximum number of seconds to wait, the
interval at which the closure should be evaluated, the closure, and an optional
failure message:

    $browser->waitUsing( 10, 1, function () use (  $something  ) {
        return $something->isReady();
    }, "Something wasn't ready in time." );


### Scrolling An Element Into View

Sometimes you may not be able to click on an element because it is outside of
the viewable area of the browser. The `scrollIntoView` method will scroll the
browser window until the element at the given selector is within the view:

    $browser->scrollIntoView('.selector')
            ->click('.selector');


## Available Assertions

Mantle Browser Testing provides a variety of assertions that you may make against your
application. All of the available assertions are documented in the list below:

[assertTitle](#assert-title)
[assertTitleContains](#assert-title-contains)
[assertUrlIs](#assert-url-is)
[assertSchemeIs](#assert-scheme-is)
[assertSchemeIsNot](#assert-scheme-is-not)
[assertHostIs](#assert-host-is)
[assertHostIsNot](#assert-host-is-not)
[assertPortIs](#assert-port-is)
[assertPortIsNot](#assert-port-is-not)
[assertPathBeginsWith](#assert-path-begins-with)
[assertPathIs](#assert-path-is)
[assertPathIsNot](#assert-path-is-not)
[assertRouteIs](#assert-route-is)
[assertQueryStringHas](#assert-query-string-has)
[assertQueryStringMissing](#assert-query-string-missing)
[assertFragmentIs](#assert-fragment-is)
[assertFragmentBeginsWith](#assert-fragment-begins-with)
[assertFragmentIsNot](#assert-fragment-is-not)
[assertHasCookie](#assert-has-cookie)
[assertHasPlainCookie](#assert-has-plain-cookie)
[assertCookieMissing](#assert-cookie-missing)
[assertPlainCookieMissing](#assert-plain-cookie-missing)
[assertCookieValue](#assert-cookie-value)
[assertPlainCookieValue](#assert-plain-cookie-value)
[assertSee](#assert-see)
[assertDontSee](#assert-dont-see)
[assertSeeIn](#assert-see-in)
[assertDontSeeIn](#assert-dont-see-in)
[assertSeeAnythingIn](#assert-see-anything-in)
[assertSeeNothingIn](#assert-see-nothing-in)
[assertScript](#assert-script)
[assertSourceHas](#assert-source-has)
[assertSourceMissing](#assert-source-missing)
[assertSeeLink](#assert-see-link)
[assertDontSeeLink](#assert-dont-see-link)
[assertInputValue](#assert-input-value)
[assertInputValueIsNot](#assert-input-value-is-not)
[assertChecked](#assert-checked)
[assertNotChecked](#assert-not-checked)
[assertRadioSelected](#assert-radio-selected)
[assertRadioNotSelected](#assert-radio-not-selected)
[assertSelected](#assert-selected)
[assertNotSelected](#assert-not-selected)
[assertSelectHasOptions](#assert-select-has-options)
[assertSelectMissingOptions](#assert-select-missing-options)
[assertSelectHasOption](#assert-select-has-option)
[assertSelectMissingOption](#assert-select-missing-option)
[assertValue](#assert-value)
[assertAttribute](#assert-attribute)
[assertAriaAttribute](#assert-aria-attribute)
[assertDataAttribute](#assert-data-attribute)
[assertVisible](#assert-visible)
[assertPresent](#assert-present)
[assertMissing](#assert-missing)
[assertDialogOpened](#assert-dialog-opened)
[assertEnabled](#assert-enabled)
[assertDisabled](#assert-disabled)
[assertButtonEnabled](#assert-button-enabled)
[assertButtonDisabled](#assert-button-disabled)
[assertFocused](#assert-focused)
[assertNotFocused](#assert-not-focused)
[assertAuthenticated](#assert-authenticated)
[assertGuest](#assert-guest)
[assertAuthenticatedAs](#assert-authenticated-as)
[assertVue](#assert-vue)
[assertVueIsNot](#assert-vue-is-not)
[assertVueContains](#assert-vue-contains)
[assertVueDoesNotContain](#assert-vue-does-not-contain)

#### assertTitle

Assert that the page title matches the given text:

    $browser->assertTitle( $title );


#### assertTitleContains

Assert that the page title contains the given text:

    $browser->assertTitleContains( $title );


#### assertUrlIs

Assert that the current URL ( without the query string ) matches the given string:

    $browser->assertUrlIs( $url );


#### assertSchemeIs

Assert that the current URL scheme matches the given scheme:

    $browser->assertSchemeIs( $scheme );


#### assertSchemeIsNot

Assert that the current URL scheme does not match the given scheme:

    $browser->assertSchemeIsNot( $scheme );


#### assertHostIs

Assert that the current URL host matches the given host:

    $browser->assertHostIs( $host );


#### assertHostIsNot

Assert that the current URL host does not match the given host:

    $browser->assertHostIsNot( $host );


#### assertPortIs

Assert that the current URL port matches the given port:

    $browser->assertPortIs( $port );


#### assertPortIsNot

Assert that the current URL port does not match the given port:

    $browser->assertPortIsNot( $port );


#### assertPathBeginsWith

Assert that the current URL path begins with the given path:

    $browser->assertPathBeginsWith('/home');


#### assertPathIs

Assert that the current path matches the given path:

    $browser->assertPathIs('/home');


#### assertPathIsNot

Assert that the current path does not match the given path:

    $browser->assertPathIsNot('/home');


#### assertRouteIs

Assert that the current URL matches the given [named
route's](/docs/{{version}}/routing#named-routes) URL:

    $browser->assertRouteIs( $name, $parameters );


#### assertQueryStringHas

Assert that the given query string parameter is present:

    $browser->assertQueryStringHas( $name );

Assert that the given query string parameter is present and has a given value:

    $browser->assertQueryStringHas( $name, $value );


#### assertQueryStringMissing

Assert that the given query string parameter is missing:

    $browser->assertQueryStringMissing( $name );


#### assertFragmentIs

Assert that the URL's current hash fragment matches the given fragment:

    $browser->assertFragmentIs( 'anchor');


#### assertFragmentBeginsWith

Assert that the URL's current hash fragment begins with the given fragment:

    $browser->assertFragmentBeginsWith( 'anchor');


#### assertFragmentIsNot

Assert that the URL's current hash fragment does not match the given fragment:

    $browser->assertFragmentIsNot( 'anchor');


#### assertHasCookie

Assert that the given encrypted cookie is present:

    $browser->assertHasCookie( $name );


#### assertHasPlainCookie

Assert that the given unencrypted cookie is present:

    $browser->assertHasPlainCookie( $name );


#### assertCookieMissing

Assert that the given encrypted cookie is not present:

    $browser->assertCookieMissing( $name );


#### assertPlainCookieMissing

Assert that the given unencrypted cookie is not present:

    $browser->assertPlainCookieMissing( $name );


#### assertCookieValue

Assert that an encrypted cookie has a given value:

    $browser->assertCookieValue( $name, $value );


#### assertPlainCookieValue

Assert that an unencrypted cookie has a given value:

    $browser->assertPlainCookieValue( $name, $value );


#### assertSee

Assert that the given text is present on the page:

    $browser->assertSee( $text );


#### assertDontSee

Assert that the given text is not present on the page:

    $browser->assertDontSee( $text );


#### assertSeeIn

Assert that the given text is present within the selector:

    $browser->assertSeeIn( $selector, $text );


#### assertDontSeeIn

Assert that the given text is not present within the selector:

    $browser->assertDontSeeIn( $selector, $text );


#### assertSeeAnythingIn

Assert that any text is present within the selector:

    $browser->assertSeeAnythingIn( $selector );


#### assertSeeNothingIn

Assert that no text is present within the selector:

    $browser->assertSeeNothingIn( $selector );


#### assertScript

Assert that the given JavaScript expression evaluates to the given value:

    $browser->assertScript('window.isLoaded')
            ->assertScript('document.readyState', 'complete');


#### assertSourceHas

Assert that the given source code is present on the page:

    $browser->assertSourceHas( $code );


#### assertSourceMissing

Assert that the given source code is not present on the page:

    $browser->assertSourceMissing( $code );


#### assertSeeLink

Assert that the given link is present on the page:

    $browser->assertSeeLink( $linkText );


#### assertDontSeeLink

Assert that the given link is not present on the page:

    $browser->assertDontSeeLink( $linkText );


#### assertInputValue

Assert that the given input field has the given value:

    $browser->assertInputValue( $field, $value );


#### assertInputValueIsNot

Assert that the given input field does not have the given value:

    $browser->assertInputValueIsNot( $field, $value );


#### assertChecked

Assert that the given checkbox is checked:

    $browser->assertChecked( $field );


#### assertNotChecked

Assert that the given checkbox is not checked:

    $browser->assertNotChecked( $field );


#### assertRadioSelected

Assert that the given radio field is selected:

    $browser->assertRadioSelected( $field, $value );


#### assertRadioNotSelected

Assert that the given radio field is not selected:

    $browser->assertRadioNotSelected( $field, $value );


#### assertSelected

Assert that the given dropdown has the given value selected:

    $browser->assertSelected( $field, $value );


#### assertNotSelected

Assert that the given dropdown does not have the given value selected:

    $browser->assertNotSelected( $field, $value );


#### assertSelectHasOptions

Assert that the given array of values are available to be selected:

    $browser->assertSelectHasOptions( $field, $values );


#### assertSelectMissingOptions

Assert that the given array of values are not available to be selected:

    $browser->assertSelectMissingOptions( $field, $values );


#### assertSelectHasOption

Assert that the given value is available to be selected on the given field:

    $browser->assertSelectHasOption( $field, $value );


#### assertSelectMissingOption

Assert that the given value is not available to be selected:

    $browser->assertSelectMissingOption( $field, $value );


#### assertValue

Assert that the element matching the given selector has the given value:

    $browser->assertValue( $selector, $value );


#### assertAttribute

Assert that the element matching the given selector has the given value in the
provided attribute:

    $browser->assertAttribute( $selector, $attribute, $value );


#### assertAriaAttribute

Assert that the element matching the given selector has the given value in the
provided aria attribute:

    $browser->assertAriaAttribute( $selector, $attribute, $value );

For example, given the markup `<button aria-label="Add"></button>`, you may
assert against the `aria-label` attribute like so:

    $browser->assertAriaAttribute('button', 'label', 'Add')


#### assertDataAttribute

Assert that the element matching the given selector has the given value in the
provided data attribute:

    $browser->assertDataAttribute( $selector, $attribute, $value );

For example, given the markup `<tr id="row-1" data-content="attendees"></tr>`,
you may assert against the `data-label` attribute like so:

    $browser->assertDataAttribute('#row-1', 'content', 'attendees')


#### assertVisible

Assert that the element matching the given selector is visible:

    $browser->assertVisible( $selector );


#### assertPresent

Assert that the element matching the given selector is present:

    $browser->assertPresent( $selector );


#### assertMissing

Assert that the element matching the given selector is not visible:

    $browser->assertMissing( $selector );


#### assertDialogOpened

Assert that a JavaScript dialog with the given message has been opened:

    $browser->assertDialogOpened( $message );


#### assertEnabled

Assert that the given field is enabled:

    $browser->assertEnabled( $field );


#### assertDisabled

Assert that the given field is disabled:

    $browser->assertDisabled( $field );


#### assertButtonEnabled

Assert that the given button is enabled:

    $browser->assertButtonEnabled( $button );


#### assertButtonDisabled

Assert that the given button is disabled:

    $browser->assertButtonDisabled( $button );


#### assertFocused

Assert that the given field is focused:

    $browser->assertFocused( $field );


#### assertNotFocused

Assert that the given field is not focused:

    $browser->assertNotFocused( $field );


#### assertAuthenticated

Assert that the user is authenticated:

    $browser->assertAuthenticated();


#### assertGuest

Assert that the user is not authenticated:

    $browser->assertGuest();


#### assertAuthenticatedAs

Assert that the user is authenticated as the given user:

    $browser->assertAuthenticatedAs( $user );

## Pages

Sometimes, tests require several complicated actions to be performed in
sequence. This can make your tests harder to read and understand. Pages
allow you to define expressive actions that may then be performed on a given
page via a single method. Pages also allow you to define short-cuts to common
selectors for your application or for a single page.


### Generating Pages

To generate a page object, execute the `mantle browser-testing:page` wp-cli command. All page
objects will be placed in your application's `tests/browser/pages` directory:

    wp mantle browser-testing:page Login


### Configuring Pages

By default, pages have three methods: `url`, `assert`, and `elements`. We will
discuss the `url` and `assert` methods now. The `elements` method will be
[discussed in more detail below](#shorthand-selectors).


#### The `url` Method

The `url` method should return the path of the URL that represents the page.
Mantle Browser Testing will use this URL when navigating to the page in the browser:

```php
/**
 * Get the URL for the page.
 *
 * @return string
 */
public function url(){
  return '/login';
}
```

#### The `assert` Method

The `assert` method may make any assertions necessary to verify that the browser
is actually on the given page. It is not actually necessary to place anything
within this method; however, you are free to make these assertions if you wish.
These assertions will be run automatically when navigating to the page:

```php
/**
 * Assert that the browser is on the page.
 *
 * @return void
 */
public function assert( Browser $browser ) {
  $browser->assertPathIs( $this->url() );
}
```


### Navigating To Pages

Once a page has been defined, you may navigate to it using the `visit` method:

```php
use Tests\Browser\Pages\Login;

$browser->visit( new Login() );
```

Sometimes you may already be on a given page and need to "load" the page's
selectors and methods into the current test context. This is common when
pressing a button and being redirected to a given page without explicitly
navigating to it. In this situation, you may use the `on` method to load the
page:

```php
use Tests\Browser\Pages\Create_Playlist;

$browser->visit( '/dashboard' )
	->clickLink( 'Create Playlist' )
	->on( new CreatePlaylist() )
	->assertSee( '@create' );
```

### Shorthand Selectors

The `elements` method within page classes allow you to define quick,
easy-to-remember shortcuts for any CSS selector on your page. For example, let's
define a shortcut for the "email" input field of the application's login page:

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements() {
        return [
            '@email' => 'input[name=email]',
        ];
    }

Once the shortcut has been defined, you may use the shorthand selector anywhere
you would typically use a full CSS selector:

    $browser->type( '@email', 'taylor@laravel.com' );


#### Global Shorthand Selectors

After installing Mantle Browser Testing, a base `Page` class will be placed in your
`tests/browser/pages` directory. This class contains a `site_elements` method
which may be used to define global shorthand selectors that should be available
on every page throughout your application:

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function site_elements() {
        return [
            '@element' => '#selector',
        ];
    }


### Page Methods

In addition to the default methods defined on pages, you may define additional
methods which may be used throughout your tests. For example, let's imagine we
are building a music management application. A common action for one page of the
application might be to create a playlist. Instead of re-writing the logic to
create a playlist in each test, you may define a `createPlaylist` method on a
page class:

    <?php

    namespace Tests\Browser\Pages;

    use Mantle\Browser_Testing\Browser;

    class Dashboard extends Page
    {
        // Other page methods...

        /**
         * Create a new playlist.
         *
         * @param  Browser  $browser
         * @param  string  $name
         * @return void
         */
        public function createPlaylist( Browser $browser, $name )
        {
            $browser->type('name', $name)
                    ->check('share')
                    ->press('Create Playlist');
        }
    }

Once the method has been defined, you may use it within any test that utilizes
the page. The browser instance will automatically be passed as the first
argument to custom page methods:

    use Tests\Browser\Pages\Dashboard;

    $browser->visit( new Dashboard )
            ->createPlaylist('My Playlist')
            ->assertSee('My Playlist');


## Components

Components are similar to Mantle Browser Testing’s “page objects”, but are intended for pieces of
UI and functionality that are re-used throughout your application, such as a
navigation bar or notification window. As such, components are not bound to
specific URLs.


### Creating Components

As shown above, a "date picker" is an example of a component that might exist
throughout your application on a variety of pages. It can become cumbersome to
manually write the browser automation logic to select a date in dozens of tests
throughout your test suite. Instead, we can define a component to represent
the date picker, allowing us to encapsulate that logic within the component:

    <?php

    namespace Tests\Browser\Components;

    use Mantle\Browser_Testing\Browser;
    use Mantle\Browser_Testing\Component as BaseComponent;

    class DatePicker extends BaseComponent
    {
        /**
         * Get the root selector for the component.
         *
         * @return string
         */
        public function selector()
        {
            return '.date-picker';
        }

        /**
         * Assert that the browser page contains the component.
         *
         * @param  Browser  $browser
         * @return void
         */
        public function assert( Browser $browser )
        {
            $browser->assertVisible($this->selector());
        }

        /**
         * Get the element shortcuts for the component.
         *
         * @return array
         */
        public function elements()
        {
            return [
                '@date-field' => 'input.datepicker-input',
                '@year-list' => 'div > div.datepicker-years',
                '@month-list' => 'div > div.datepicker-months',
                '@day-list' => 'div > div.datepicker-days',
            ];
        }

        /**
         * Select the given date.
         *
         * @param  \Mantle\Brower_Testing\Browser  $browser
         * @param  int  $year
         * @param  int  $month
         * @param  int  $day
         * @return void
         */
        public function selectDate( Browser $browser, $year, $month, $day )
        {
            $browser->click('@date-field')
                    ->within('@year-list', function ( $browser ) use ( $year ) {
                        $browser->click( $year );
                    })
                    ->within('@month-list', function ( $browser ) use ( $month ) {
                        $browser->click( $month );
                    })
                    ->within('@day-list', function ( $browser ) use ( $day ) {
                        $browser->click( $day );
                    } );
        }
    }


### Using Components

Once the component has been defined, we can easily select a date within the date
picker from any test. And, if the logic necessary to select a date changes, we
only need to update the component:

    <?php

    namespace Tests\Browser;

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Mantle\Browser_Testing\Browser;
    use Tests\Browser\Components\DatePicker;
    use Tests\Browser_Test_Case;

    class ExampleTest extends Browser_Test_Case
    {
        /**
         * A basic component test example.
         *
         * @return void
         */
        public function testBasicExample()
        {
            $this->browse(function ( Browser $browser ) {
                $browser->visit('/')
                        ->within(new DatePicker, function ( $browser ) {
                            $browser->selectDate(2019, 1, 30);
                        })
                        ->assertSee('January');
            } );
        }
    }
