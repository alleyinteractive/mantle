# Querying Models

- [Querying Models](#querying-models)
	- [Querying the Model Directly](#querying-the-model-directly)
	- [Querying Posts with Terms](#querying-posts-with-terms)
	- [Querying with Meta](#querying-with-meta)
	- [Ordering Results](#ordering-results)
	- [Limitations](#limitations)
- [Querying Multiple Models](#querying-multiple-models)

Models support a fluent query builder that will return a easy-to-use Collection
of models.

## Querying the Model Directly
```php
// Posts with a post_name equal to 'slug-to-find'.
Example_Post::whereSlug( 'slug-to-find' )->first();

// You can also use the `where()` method diretly.
Example_Post::where( 'slug', 'slug-to-find' )->first();

// Posts in a list of IDs.
Example_Post::whereIn( [ 1, 2, 3 ] )->get();

// Posts not a list of IDs.
Example_Post::whereNotIn( [ 1, 2, 3 ] )->get();
```

## Querying Posts with Terms
Only `Post` models support querying against terms.

```php
// Get the first 10 posts in the 'term-slug' tag.
Example_Post::whereTerm( 'term-slug', 'post_tag' )
  ->take( 10 )
  ->get();

// Get the first 10 posts in the 'term-slug' or 'other-tag' tags.
Example_Post::whereTerm( 'term-slug', 'post_tag' )
  ->orWhereTerm( 'other-tag', 'post_tag' )
  ->take( 10 )
  ->get();

// Get the first 10 posts in the taxonomy term controlled by `Example_Term`.
$term = Example_Term::first();
Example_Post::whereTerm( $term )->take( 10 )->get();
```

## Querying with Meta
Normal concerns for querying against a model's meta still should be observed.
The `Post` and `Term` models support querying with meta.

```php
// Instance of Example_Post if found.
Example_Post::whereMeta( 'meta-key', 'meta-value' )->first();

// Multiple meta keys to match.
Example_Post::whereMeta( 'meta-key', 'meta-value' )
  ->andWhereMeta( 'another-meta-key', 'another-value' )
  ->first();

Example_Post::whereMeta( 'meta-key', 'meta-value' )
  ->orWhereMeta( 'another-meta-key', 'another-value' )
  ->first();
```

## Ordering Results
By default, the results will be order by `post_date` descending just like core.

```php
Example_Post::query()->orderBy( 'name', 'asc' )->get();
```

## Limitations
Not all fields are supported to be queried against since this is a fluent
interface for the underlying `WP_Query` and `WP_Tax_Query` classes.


# Querying Multiple Models
Multiple models of the same type (posts/terms/etc.) can be queried together.
There are some limitations and features that cannot be used including query
scopes.

```php
use Mantle\Framework\Database\Query\Post_Query_Builder;

use App\Models\Post;
use App\Models\Another_Post;

Post_Query_Builder::create( [ Post::class, Another_Post::class ] )
  ->whereMeta( 'shared-meta', 'meta-value' )
	->get();
```
