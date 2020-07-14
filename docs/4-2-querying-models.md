Querying Models
===============

Models support a fluent query builder that will return a easy-to-use Collection of models.

## Querying the Model
```php
// Posts with a post_name equal to 'slug-to-find'.
Example_Post::whereSlug( 'slug-to-find' )->first();

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
Normal concerns for querying against a model's meta still should be observed. The `Post` and `Term` models support querying with meta.

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
Not all fields are supported to be queried against since this is a fluent interface for the underlying `WP_Query` and `WP_Tax_Query` classes.
