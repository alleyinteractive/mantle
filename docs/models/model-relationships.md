# Model Relationships

- [Model Relationships](#model-relationships)
	- [Introduction](#introduction)
	- [Defining Relationships](#defining-relationships)
		- [Has One/Has Many](#has-onehas-many)
			- [Storing](#storing)
		- [Belongs To](#belongs-to)
			- [Storing](#storing-1)

## Introduction
Data in an application will often have a relationship with other data. In
Mantle, data represented as models can have relationships with other models with
ease.

## Defining Relationships
Relationships are defined as methods on the model. Since, like models
themselves, relationships also serve as powerful query builders, defining
relationships as methods provides powerful method chaining and querying
capabilities. For example, we may chain additional constraints on this posts
relationship:

```php
$post->sponsors()->whereMeta( 'active', '1' )->get();
```

Models can exist between posts as well as between posts and term models.
Relationships between posts will use an underlying meta query while
relationships between posts and terms will use a taxonomy query.

### Has One/Has Many
Relationships defined as having one or many will have references to the current
model stored on other models. One common example would be a 'post -> sponsor'
relationship. The sponsor's ID will be stored on one or many post objects.

```php
class Sponsor extends Base_Post {
  // ...

  public function posts() {
    // Uses the 'sponsor_id' meta field on the post to retrieve the sponsor.
    return $this->has_many( Post::class );
  }

  public function special_post() {
    return $this->has_one( Post::class )->whereMeta( 'special-meta', '1' );
  }
}
```

#### Storing
The relationship can automatically setup the proper meta values to define a
relationship.

```php
$sponsor->save( $post );

$sponsor->remove( $post );
```

### Belongs To
Relationships can be define as belong to another model will have the reference
stored on the other model. In the example of a  `post -> sponsor` relationship,
the sponsor's ID will be stored as meta on the post object.

```php
class Post extends Base_Post {
  // ...

  public function sponsor() {
    // Uses the 'sponsor_id' meta field on the post to retrieve the sponsor.
    return $this->belongs_to( Sponsor::class );
  }
}
```

#### Storing
The relationship can automatically setup the proper meta values on the model to
define a relationship.

```php
$sponsor->associate( $post );

$sponsor->dissociate( $post );
```
