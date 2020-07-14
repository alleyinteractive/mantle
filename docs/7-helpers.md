Helpers
=======

Mantle includes a variety of global "helper" functions (props to Laravel) to make life easier.

## Application Helpers

### `app()`
Retrieve the global Mantle Application Container or a specific binding on the container.

```php
app();

app( Specific_Binding::class );
```

### `config()`
Retrieve a configuration value for the application in a dot-notation.

```php
config( 'app.value-to.get', 'default value' );
```

### `mantle_base_path()`
Retrieve the base path to the application.

```php
mantle_base_path();
```

### `response()`
Helper to build a response for a route (see 'Requests Lifecycle').

```php
response()->view( 'view/to/load' );

response()->json( [ 1, 2, 3 ] );
```

### `view()`
Return a new instance of a view.

```php
echo view( 'view-to-load', [ 'variable' => 123 ] );
```

### `loop()`
Loop over a collection/array of post objects. Supports a collection or array of `WP_Post` objects, Mantle Models, post IDs, or a `WP_Query` object.

```php
$posts = Post::all();
echo loop( $posts, 'view-to-load' );
```

### `iterate()`
Iterate over a collection/array of arbitrary data. Each view is passed `index` and `item` as a variable.

```php
echo iterate( [ 1, 2, 3 ], 'view-to-load' );
```

### `mantle_get_var()`
Get the variable for a template part.

```php
mantle_get_var( 'index', 'default-value' );
```

### `route()`
Get a URL to a specific route.

```php
route( 'route-name' );
```

### `abort()`
Throw a HTTP exception with a specific status code inside of a route.

```php
abort( 404 );

abort( 400, 'Invalid arguments sent!' );
```

### `abort_if()` and `abort_unless()`
Abort if the given condition passes or fails a truth test.

```php
abort_if( $value_to_check, 404 );

abort_unless( $value_to_check, 404 );
```

## Array Helpers
The `Mantle\Framework\Support\Arr` class contains all the Laravel array helper methods you might be familiar with (some methods have been renamed to match WordPress coding standards). You can reference those [here](https://laravel.com/docs/7.x/helpers#arrays).

## String Helpers
The `Mantle\Framework\Support\Str` class contains all the Laravel string helper methods you might be familiar with. You can reference those [here](https://laravel.com/docs/7.x/helpers#strings).
