# WordPress Hooks

- [WordPress Hooks](#wordpress-hooks)
	- [Find a Hook's Usage in the Codebase](#find-a-hooks-usage-in-the-codebase)
	- [Using Hooks with Type Hints](#using-hooks-with-type-hints)

## Find a Hook's Usage in the Codebase
Quickly calculate the usage of a specific WordPress hook throughout your code
base. Mantle will read all specified files in a specific path to find all uses
of a specific action/filter along with their respective line number.

On initial scan of the file system, the results can be a bit slow to build a
cache of all files on the site. By default Mantle will ignore all `test` and
`vendor/` files. The default search path is the `wp-content/` folder of your
installation.

```bash
wp mantle hook-usage <hook> [--search-path] [--format]
```

## Using Hooks with Type Hints
To improve on WordPress' actions/filters to allow for safer use of type hints,
Mantle providers a wrapper on-top of `add_action()` and `add_filter()`. You can
use either the helper methods in the `Mantle\Framework\Helpers` namespace via
`Mantle\Framework\Helpers\add_action` and `Mantle\Framework\Helpers\add_filter`
or the `Event` facade via `Event::action()` and `Event::filter()`.

```php
use function Mantle\Framework\Helpers\add_action;

add_action(
	'pre_get_posts',
	function( \WP_Query $query ) {
		// $query will always be an instance of WP_Query.
	}
);
```

```php
use function Mantle\Framework\Helpers\add_filter;

add_filter(
	'the_posts',
	function( array $posts ) {
		// $posts will always be an array.
	}
);

// Also supports translating between a Arrayable and an array.

add_filter(
	'the_posts',
	function( Collection $posts ) {
		// $posts will always be a Collection.
		return $posts->to_array();
	}
);

apply_filters( 'the_filter_to_apply', [ 1, 2, 3 ] );
```
