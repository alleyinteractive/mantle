Models
======

Models provide a fluent way to interface with objects in WordPress. Models can be either a post type, a term, or a subset of a post type! Models can also allow dynamic registration of a post type, REST API fields, and more. To make life easier for developers, Mantle models were designed with uniformity in mind

## Supported Model Types
Data Type | Model Class
--------- | -----------
Attachment | `Mantle\Framework\Database\Model\Attachment`
Comment | `Mantle\Framework\Database\Model\Comment`
Post | `Mantle\Framework\Database\Model\Post`
Site | `Mantle\Framework\Database\Model\Site`
Term | `Mantle\Framework\Database\Model\Term`
User | `Mantle\Framework\Database\Model\User`

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

## Interacting with Models
Setting/updating data with a model can be done using the direct attribute name you wish to update or a handy alias (see Core Object).

```php
$post->content = 'Content to set.';

// is the same as...
$post->post_content = 'Content to set.';
```

### Field Aliases
#### Post Aliases

Alias | Field
----- | -----
`content` | `post_content`
`description` | `post_excerpt`
`id` | `ID`
`title` | `post_title`
`name` | `post_title`
`slug` | `post_name`

#### Term Aliases

Alias | Field
----- | -----
`id` | `term_id`

### Saving/Updating Models
The `save()` method on the model will store the data for the respective model. It also supports an array of attributes to set for the model before saving.

```php
$post->content = 'Content to set.';
$post->save();

$post->save( [ 'content' => 'Fresher content' ] );
```

### Deleting Models
The `delete()` method on the model will delete the model. On `Post` models, the delete method will attempt to trash the post if the post type supports it. You can pass `$force = true` to bypass that.

```php
// Force to delete it.
$post->delete( true );

$term->delete();
```

### Working with Meta
The `Post`, `Term`, and `User` model types support setting meta easily.

```php
$model->set_meta( 'meta-key', 'meta-value' );
$model->save( [ 'meta' => [ 'meta-key' => 'meta-value' ] ] );
$model->meta->meta_key = 'meta-value';

$model->delete_meta( 'meta-key' );
$model->save( [ 'meta' => [ 'meta-key' => '' ] ] );

$value = $model->get_meta( 'meta-key' );
$value = $model->meta->meta_key;
```

## Core Object
To promote a uniform interface of data across models, all models implement `Mantle\Framework\Contracts\Database\Core_Object`. This provides a consistent set of methods to invoke on any model you may come across. A developer shouldn't have to check the model type before retrieving a field. This helps promote interoperability between model types in your application.

```php
id(): int
name(): string
slug(): string
description(): string
parent(): ?Core_Object
permalink(): ?string
```

## Events
In the spirit of interoperability, you can listen to model events in a uniform way across all model types. Currently only `Post` and `Term` models support events. Model events can be registered inside or outside a model.

```php
namespace App\Models;

use Mantle\Framework\Database\Model\Post as Base_Post;

class Post extends Base_Post {
	protected static function boot() {
		static::created( function( $post ) {
			//
		} );
	}
}
```

The following events are supported:

Method | Event
------ | -----
`created` | After a model is created.
`updating` | Before a model is updated.
`updated` | After a model is updated.
`deleting` | Before a model is deleted.
`deleted` | After a model is deleted.
`trashing` | Before a model is trashed.
`trashed` | After a model is trashed.
