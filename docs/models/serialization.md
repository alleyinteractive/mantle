# Serialization

[[toc]]

Often times a Model will need to be converted to arrays or JSON for use in a API
endpoint. Mantle includes convenient methods for making these conversions and
controlling which attributes remain hidden/visible in your serializations.

## Serializing Models

Models implement the `Arrayable` contract and include a convenient `to_array()`
method to convert a model to an array. This method is recursive, so all
attributes and all relations (including the relations of relations) will be
converted to arrays:

```php
$post = App\Models\Post::first();

return $post->to_array();
```

A collection of models will also properly serialize all models to array.

```php
$posts = App:models\Post::all();

return $posts->to_array();
```

## Hiding Attributes from Serialization

Sometimes you may need to hide attributes from serialization to prevent public
display. Model attributes can be hidden from serialization using the `$hidden`
property on your model, or using the `set_hidden()` or `make_hidden_if()`
methods on the model.

```php
namespace App\Models;

use Mantle\Framework\Database\Model\Post;

class Product extends Post {
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [ 'post_title' ];
}
```

Alternatively, you may use the `visible` property to define an allow list of
attributes that should be included in your model's array and JSON
representation. In addition to the `$visible` property, you can also use
`set_visible()` or `make_visible_if()` methods on the model, too. Once an
attribute is set visible, all other attributes will be hidden:

```php
namespace App\Models;

use Mantle\Framework\Database\Model\Post;

class Product extends Post {
	/**
	 * The attributes that should be visible for arrays.
	 *
	 * @var array
	 */
	protected $visible = [ 'post_title', 'post_content ];
}
```

### Temporarily Setting Attribute Visibility

Attributes on a model can use the additional methods on the model to set
attribute visibility.

```php
$post->make_visible( 'attribute' )->to_array():
$post->make_hidden( 'title' )->to_array():
```

## Appending Values to Serialization

When converting to an array or JSON, you may need to append attributes that do
not have a corresponding column in your database. This can be accomplished by
defining a custom accessor for the value and including it in the `appends`
property on your model:

```php
use Mantle\Framework\Database\Model\Post;

class Author extends Post {
	protected $appends = [ 'avatar' ];

	public function get_avatar_attribute(): string {
		return "https://example.org/{$this->id}.jpg";
	}
}
```

In the `Author` model, an `avatar` attribute will be included in the serialized
response. An attribute can also be appended at run-time:

```php
$author->append( 'avatar' )->to_array();
$author->set_appends( 'avatar' )->to_array();
```
