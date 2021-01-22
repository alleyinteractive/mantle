# Model Relationships

[[toc]]

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
class Sponsor extends Post {
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

### Belongs To / Belongs To Many

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

  public function tags() {
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

### Post-to-Post Relationships

Posts can define relationships between other posts using meta keys by default.
However, this can result in poor query performance when querying against the
relationship. Mantle supports defining relationships between posts using a
internal taxonomy. This will result in better query performance when loading the
post's relationships.

```php
class Sponsor extends Post {
  public function posts() {
    return $this->has_many( Post::class )->uses_terms();
  }
}
```

On the flip side, the belongs-to relationship needs to use terms as well.

```php
class Post extends Base_Post {
  public function sponsor() {
    return $this->belongs_to( Sponsor::class )->uses_terms();
  }
}
```

### Post-to-Term Relationships

Post-to-term relationships should always use a Has One/Has Many in both
directions since post and terms in WordPress are bidirectional. Attempting to
define a relation between a post and a term using Belongs To will result in an
error being thrown.

## Querying Relationships

Relationships can be queried by using the method on the model (which uses a [query
builder](./querying-models.md) to construct the query).

```php
$post->sponsors()->get();

$post->sponsors()->first();
```

Relationships can also be access as magic properties on the model instance.

```php
echo $post->sponsor->title;

foreach ( $post->sponsors as $sponsor ) {
	echo $sponsor->title;
}
```

## Eager Loading Relationships

When using relationships as model properties, related models are "lazy loaded"
by default. This means that the relationship data is not loaded until the first
time you access the property. Mantle supports eager loading relationships to
load all model relationships at the time of the initial query for the parent
model. This can prevent the "N + 1" query problem. Here's an example of a
problem eager loading can prevent:

1. A page includes a list of blog posts.
2. Each blog post has a sponsor relationship used.
3. During the loop, each blog post will cause an additional query (the "N + 1"
   problem) to retrieve the post's sponsor.

Eager Loading the relationship can prevent this by loading all sponsors for the
blog posts in a collection at once. Here is an example model:

```php
class Blog_Post extends Post {
	public function sponsor() {
		return $this->has_one( Sponsor::class );
	}
}
```

Now, let's retrieve all the blog posts and the sponsors:

```php
$posts = Blog_Post::with( 'sponsor' )->get();

foreach ( $posts as $post ) {
	echo $post->title;

	echo $post->sponsor->title;
}
```

This loop will execute two queries: the initial query to retrieve the blog posts
and another query to retrieve the sponsors. Without eager loading, this would
perform "N + 1" queries on the page.

Eager Loading is by default an opt-in feature of Mantle models for performance.
A model can include an eager-loaded relationship by default by setting the with
property on the model.

```php
class Blog_Post extends Post {
	/**
	 * The relations to eager load on every query.
	 *
	 * @var string[]
	 */
	protected $with = [ 'sponsor' ];
}
```
