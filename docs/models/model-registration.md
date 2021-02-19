# Model Registration

[[toc]]

Let's aim to spend less time writing registration code and more time building
websites.

## Registering Post Types/Taxonomies
Models can auto-register the object type they represent (a post type for a post
model, a taxonomy for a taxonomy model).

```php
namespace App\Models;

use Mantle\Contracts\Database\Registrable;
use Mantle\Database\Model\Post;
use Mantle\Database\Model\Registration\Register_Post_Type;

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

From here, the model can be added to your `config/models.php` file under the
`register` property and the post type will automatically be created.

```php
return [
  // ...

  'register' => [
    \App\Models\Example_Post::class,
  ],
];
```

### Register REST API Fields
Models can define REST API fields inside of a model easily. Registration should
be defined in the model's `boot()` method. To ensure the model's fields are
always registered, the model should beadded to the `config/models.php` file
under the `register` property.

```php
namespace App\Models;

use Mantle\Contracts\Database\Registrable_Fields;
use Mantle\Database\Model\Post as Base_Post;
use Mantle\Database\Model\Registration\Register_Rest_Fields;

class Post extends Base_Post implements Registrable_Fields {
  use Register_Rest_Fields;

  protected static function boot() {
    static::register_field(
      'field-to-register',
      function() {
        return 'value to return';
      }
    )
    ->set_update_callback(
      function( $value ) {
        // ...
      }
    );
  }
}
```

### Register Meta Fields
Models can define meta values to associate with the model. Similar to
registering a model's REST API field, registration should be defined in the
model's `boot()` method. To ensure the fields are always registered, the model
should be added to the `config/models.php` file under the `register` property.

By default, Mantle will pass the `object_subtype` argument for you for the
model, registering meta only for the specific object type and object subtype the
model represents. In the following example, the meta will be added to the `post`
object type in WordPress and the `product` object subtype.

```php
namespace App\Models;

use Mantle\Contracts\Database\Registrable_Meta;
use Mantle\Database\Model\Post;
use Mantle\Database\Model\Registration\Register_Meta;

class Product extends Post implements Registrable_Meta {
  use Register_Meta;

  protected static function boot() {
		static::register_meta( 'product_id' );
		static::register_meta( 'feedback', [ ... ] );
  }
}
```

## Bootable Trait Methods
To allow for simplicity when writing traits that are shared among a set of
models, traits support a `boot` and `initialize` method to allow for automatic
registration of the respective trait. The trait name are suffixed with the name
of the trait lowercased (for example: `boot_{trait_name}`).

```php
trait Example_Trait {
  public function boot_example_trait() {
    // Called once per request.
  }

  public function initialize_example_trait() {
    // Called on every model instantiation.
  }
}
```

## Model Routing

Models can define post/term singular and archive routes. This will replace the
WordPress singular routes for posts and terms with no additional customization
needed. Routes inside models can use any model alias or attribute, too.

By default, any model that uses the `Register_Post_Type` or `Register_Taxonomy`
will have their routes defined for them. The default route format is
`/{object_name}/` and `/{object_name}/{slug}/` for the archive and singular
route, respectively. The model can define their own route by replacing the
`get_route()` or `get_archive_route()` methods.

::: tip
For routes that don't use the registration traits the model can still have
their routing handled by including `Mantle\Database\Model\Concerns\Custom_Post_Permalink` or
`Mantle\Database\Model\Concerns\Custom_Term_Link` traits.
:::

```php
use Mantle\Database\Model\Post;
use Mantle\Database\Model\Registration\Register_Post_Type;

class Product extends Post {
	use Register_Post_Type;

	public static function get_route(): ?string {
		return '/product/{slug}';
	}
}
```

For more information, see [Model Routing](../basics/requests.md#model-routing)
