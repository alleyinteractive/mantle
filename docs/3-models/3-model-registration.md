# Model Registration

- [Model Registration](#model-registration)
	- [Registering Post Types/Taxonomies](#registering-post-typestaxonomies)
	- [Register REST API Fields](#register-rest-api-fields)
	- [Register Meta Fields](#register-meta-fields)
- [Bootable Trait Methods](#bootable-trait-methods)

Let's aim to spend less time writing registration code and more time building
websites.

## Registering Post Types/Taxonomies
Models can auto-register the object type they represent (a post type for a post
model, a taxonomy for a taxonomy model).

```php
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

## Register REST API Fields
Models can define REST API fields inside of a model easily. Registration should
be defined in the model's `boot()` method. To ensure the model's fields are
always registered, the model should beadded to the `config/models.php` file
under the `register` property.

```php
namespace App\Models;

use Mantle\Framework\Contracts\Database\Registrable_Fields;
use Mantle\Framework\Database\Model\Post as Base_Post;
use Mantle\Framework\Database\Model\Registration\Register_Rest_Fields;

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

## Register Meta Fields
Models can define meta values to associate with the model. Similar to
registering a model's REST API field, registration should be defined in the
model's `boot()` method. To ensure the fields are always registered, the model
should beadded to the `config/models.php` file under the `register` property.

```php
// to come.
```

# Bootable Trait Methods
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
