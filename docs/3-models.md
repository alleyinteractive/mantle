Models
======

Models provide a fluent way to interface with objects in WordPress. Models can be either a post type, a term, or a subset of a post type! Models can also allow dynamic registration of a post type, REST API fields, and more.

## Generating a Model
Models can be generated through the `wp-cli` command:

```bash
wp mantle make:model <name> --model_type=<model_type> [--registrable] [--object_name] [--label_singular] [--label_plural]
```

## Defining a Model

Models live in the `app/models` folder under the `App\Models` namespace.

### Example Post Model

```php
/**
 * Example_Model class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Framework\Database\Model\Post;

/**
 * Example_Model Model.
 */
class Example_Model extends Post {
	/**
	 * Post Type
	 *
	 * @var string
	 */
	public static $object_name = 'example-model';
}
```

### Example Term Model

```php
/**
 * Example_Model class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Framework\Database\Model\Term;

/**
 * Example_Model Model.
 */
class Example_Model extends Term {
	/**
	 * Term Type
	 *
	 * @var string
	 */
	public static $object_name = 'example-model';
}
```

### Defining a Registerable Model
Models can auto-register the object type they represent (a post type for a post model, a taxonomy for a taxonomy model).


```php
/**
 * Example_Post class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Framework\Contracts\Database\Registrable;
use Mantle\Framework\Database\Model\Post;
use Mantle\Framework\Database\Model\Registration\Register_Post_Type;

/**
 * Example_Post Model.
 */
class Example_Post extends Post implements Registrable {
	use Register_Post_Type;

	/**
	 * Arguments to register the model with.
	 *
	 * @return array
	 */
	public static function get_registration_args(): array {
		return [
			'public'                => true,
			'rest_base'             => static::get_object_name(),
			'show_in_rest'          => true,
			'supports'              => [ 'author', 'title', 'editor', 'revisions', 'thumbnail', 'custom-fields', 'excerpt' ],
			'taxonomies'            => [ 'category', 'post_tag' ],
			'labels'                => [
				// A lot of labels here.
			],
		];
	}
}
```

From here, the model can be added to your `config/models.php` file under the `register` property and the post type will automatically be created.

```php
/**
 * Model Configuration
 *
 * @package Mantle
 */

use App\Models\Example_Post;

return [

	/*
	|--------------------------------------------------------------------------
	| Application Models
	|--------------------------------------------------------------------------
	|
	| This is an array of models that should be registered for the application.
	| The models can be post types, terms, etc.
	*/
	'register' => [
		Example_Post::class,
	],
];
```

## Querying Against Models
Models support a fluent query builder that will return a easy-to-use Collection of models.

### Querying Posts
```php
// Posts with a post_name equal to 'slug-to-find'.
Example_Post::whereSlug( 'slug-to-find' )->first();

// Posts in a list of IDs.
Example_Post::whereIn( [ 1, 2, 3 ] )->get();

// Posts not a list of IDs.
Example_Post::whereNotIn( [ 1, 2, 3 ] )->get();
```

### Querying Posts with Terms
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

### Querying with Meta
Normal concerns for querying against a post's meta still should be observed.

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

### Ordering Results
By default, the results will be order by `post_date` descending just like core.

```php
Example_Post::query()->orderBy( 'name', 'asc' )->get();
```

### Limitations
Not all fields are supported to be queried against since this is a fluent interface for the underlying `WP_Query` and `WP_Tax_Query` classes.
