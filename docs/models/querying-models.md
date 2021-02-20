# Querying Models

[[toc]]

Models support a fluent query builder that will return an easy-to-use Collection
of models.

## Retrieving Models

Once a model exists you are ready to start retrieving data. Each model acts as a
powerful query builder that allows you to fluently query the underlying data
that each model represents.

```php
$posts = Post::all();

foreach ( $posts as $post ) {
	echo $post->title;
}
```

### Adding Additional Constraints
The `all` method will return all the results for a model.

::: tip
For `Post` models, the `all` method will retrieve only published posts by default. You
can easily include all post statuses by calling `anyStatus()` on the model.

```php
Post::where( ... )->anyStatus()->all();
```

:::

```php
// Posts with a post_name equal to 'slug-to-find'.
Example_Post::whereSlug( 'slug-to-find' )->first();

// You can also use an `where()` method directly.
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

## Pagination

All models support pagination of results to make traversal of large sets of data
easy. The paginators will display links to the next and previous pages as well
as other pages that can be styled by your application.

### Length Aware Pagination

By default the `paginate()` method will use the Length Aware Paginator which
will calculate the total number of pages in a result set. This is what you
probably expect from a paginator: previous / next links as well as links to a
few pages before and after the current one.

```php
App\Models\Posts::paginate( 20 );
```

### Basic Pagination

'Basic' pagination is purely a next / previous link relative to the current
page. It also sets `'no_found_rows' => true` on the query to help performance for very
large data sets.

```php
App\Model\Posts::simple_paginate( 20 );
```

### Displaying Paginator Results

The paginator instances both support iteration over it to allow you to easily
loop through and display the current page's results.

```php
<ul class="post-list">
	@foreach ( $posts as $post )
		<li>
			<a href="{{ $post->url() }}">{{ $post->title() }}</a>
		</li>
	@endforeach
</ul>

{{ $posts->links() }}
```

### Customizing the Paginator Links

By default the paginator will use query strings to paginate and determine the
current URL.

```
/blog/
/blog/?page=2
...
/blog/?page=100
```

The paginator can also be set to use path pages to paginate. For example, a
paginated URL would look like `/blog/page/2/`.

```php
{{ $posts->use_path()->links() }}
```

### Append Query Parameters to Paginator Links

Arbitrary query parameters can be append to paginator links.

```php
{{ $posts->append( [ 'key' => 'value' ] )->links() }}
```

The current GET query parameters can also be automatically included on the links
as well.

```php
{{ $posts->with_query_string()->links() }}
```

### Customizing the Paginator Path

The paginator supports setting a custom base path for paginated results. By
default the paginator will use the current path (stripping `/page/n/` if it
includes it).

```php
{{ $posts->path( '/blog/' )->links() }}
```

### Converting the Paginator to JSON

The paginator supports being returned directly as a route's response.

```php
Route::get( '/posts', function() {
	return App\Posts::paginate( 20 );
} );
```

The paginator will return the results in a JSON format.

```php
{
  "current_page": 1,
  "data": [ ... ],
  "first_page_url": "\/path",
  "next_url": "\/path?page=2",
  "path": "\/path",
  "previous_url": null
}
```

# Querying Multiple Models
Multiple models of the same type (posts/terms/etc.) can be queried together.
There are some limitations and features that cannot be used including query
scopes.

```php
use Mantle\Database\Query\Post_Query_Builder;

use App\Models\Post;
use App\Models\Another_Post;

Post_Query_Builder::create( [ Post::class, Another_Post::class ] )
  ->whereMeta( 'shared-meta', 'meta-value' )
	->get();
```
