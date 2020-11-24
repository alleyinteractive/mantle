# Cache

[[toc]]

Mantle provides a fluent API for various caching back-ends. Out of the box,
Mantle will use the WordPress object cache. It additionally supports Redis and
Array cache back-ends out of the box. Caching configuration is located in the
`config/cache.php` file.

## Cache Usage

The cache cache instance can be retrieved using the
`Mantle\Framework\Facade\Cache` facade, or by type-hinting the
`Mantle\Framework\Contracts\Cache\Factory` contract for your class'
dependencies.

### Retrieving Data from the Cache

The `get` method can be used to retrieve data from the cache. It supports a
second argument to respond with a default value. Otherwise, it will return
`null` if the cache key doesn't exist.

```php
$value = Cache::get( 'key' );
$another = Cache::get( 'my-key', '123' );
```

### Checking for Item Existence

The `has` method can be used to check for a cache key's existence.

```php
if ( Cache::has( 'key' ) ) {
	// ...
}
```

### Incrementing / Decrementing Values

The increment and decrement methods may be used to adjust the value of integer
items in the cache. Both of these methods accept an optional second argument
indicating the amount by which to increment or decrement the item's value:

```php
Cache::increment( 'key' );
Cache::increment( 'key', $amount );
Cache::decrement( 'key' );
Cache::decrement( 'key', $amount );
```

### Storing Data in the Cache

The `put` method can be used to store data in the cache. By default it will be
stored indefinitely unless `$seconds` is passed to specify the cache duration.

```php
Cache::put( 'key', 'value', $seconds );
```

The `remember` method can be used to store data in the cache and pass a closure
to set a default value if the cache item does not exist.

```php
Cache::remember( 'key', $seconds, function() {
	return 'the expensive function';
} );
```

### Accessing Additional Cache Stores

Your application can access additional cache stores outside of the default cache
store by calling the `store()` method. A common use case would be to store
cached data in the WordPress object cache but shared data in a separate Redis
cache.

```php
$value = Cache::store( 'redis' )->get( 'key' );
```

### Helpers

The cache API includes a `cache()` helper which can be used to store and
retrieve data via the cache. When the `cache` function is called with a single
string argument it will return the value of the given cache key.

```php
$value = cache( 'key-to-get' );
```

If you provide an array of key / value pairs and an expiration time to the
function, it will store values in the cache for the specified duration:

```php
cache( ['key' => 'value' ], $seconds );
```

When the cache function is called without any arguments, it returns an instance
of the `Mantle\Framework\Contracts\Cache\Factory` implementation, allowing you to call
other caching methods:

```php
cache()->remember( 'posts', $seconds, function() {
	return Posts::popular()->get();
} );
```

## Cache Tags

Cache providers can support adding tags to a cache key to allow for simpler
cache keys.

```php
Cache::tags( [ 'users' ] )->get( $user_id );
Cache::tags( 'posts' )->get( $post_id );
```

The tags method will return a cache factory allowing you the ability to store
child cache keys in the same interface as the cache API.

```php
Cache::tags( [ 'users' ] )->put( 'hello', $world, $seconds );
Cache::tags( [ 'users' ] )->remember( 'name', $seconds, function() {
	return 'smith';
} );
```

## Drivers

### WordPress Object Cache

The WordPress Object Cache driver can be selected by using the `wordpress`
driver in your configuration file. The object cache must be setup separately
through the `object-cache.php` file ((documentation
here)[https://developer.wordpress.org/reference/classes/wp_object_cache/]).

### Redis

Before using a Redis cache with Mantle, you will need to either install the
PhpRedis PHP extension via PECL or install the `predis/predis` package (~1.0) via
Composer.

The Redis cluster configuration can be specified in the `config/cache.php` file.

```php
'stores' => [
	'redis'     => [
		'driver' => 'redis',
		'host'   => '127.0.0.1',
		'scheme' => 'tcp',
	],
],
```
