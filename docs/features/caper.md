# Caper

[[toc]]

Fluently distribute capabilities to roles `Caper` provides a fluent interface
for distributing post type, taxonomy, or generic primitive capabilities to
roles.

An invocation of `Caper` takes the form of "`<grant to|deny to>` `<these roles>`
`<these capabilities>`."

## Granting/Denying Capabilities For Roles

`Caper` can distribute primitive capabilities directly:

```php
use Mantle\Caper;

Caper::grant_to( 'editor' )->primitives( 'edit_theme_options' );
Caper::deny_to( 'administrator' )->primitives( 'manage_options' );
```

## Granting/Denying Capabilities for Post Types or Taxonomies

`Caper` can also distribute the primitive capabilities associated with a post
type or taxonomy. For example:

```php
use Mantle\Caper;

Caper::grant_to( 'author' )->caps_for( 'page' );
Caper::deny_to( 'editor' )->caps_for( 'category' );
```

which grants users with the `author` role all capabilities for the `page` post
type, and it denies users with the `editor` role all capabilities for the
`category` taxonomy. (Be sure to read the section on [ensuring unique post type
and taxonomy capability types](#ensuring-unique-capability-types) to avoid
unintentionally modifying capabilities for other object types.)

When granting capabilities to a post type or taxonomy, a subset of those
capabilities can be denied, or vice versa. For example:

```php
use Mantle\Caper;

Caper::grant_to( 'author' )
  ->caps_for( 'page' )
  ->except( 'delete_posts' ); // Pass "generic" keys; the actual capability names will be determined automatically.

Caper::deny_to( 'editor' )
  ->caps_for( 'category' )
  ->except( 'assign_terms' ); // Pass "generic" keys; the actual capability names will be determined automatically.
```

which grants users with the `author` role all capabilities for the `page` post
type except for the `page` capability corresponding to `delete_posts`, and it
denies users with the `editor` role all capabilities for the `category` taxonomy
except for the `category` capability corresponding to `assign_terms`.

Alternatively, an exclusive set of post type or taxonomy capabilities can be
granted or denied:

```php
use Mantle\Caper;

Caper::deny_to( 'editor' )
  ->caps_for( 'category' )
  ->only( 'delete_terms' );

Caper::grant_to( 'author' )
  ->only( 'create_posts' ) // `only()` and `except()` can occur in either order.
  ->caps_for( 'page' );
```

which denies `author` users all capabilities for the `page` post type except for
the capability corresponding to `delete_posts`, and it grants `editor` users
role all capabilities for the `category` taxonomy except for the capability
corresponding to `assign_terms`.

Multiple post types or taxonomies can be passed to `caps_for()`. Capabilities
will be granted or denied identically for all passed object types, including
exceptions or exclusives:

```php
use Mantle\Caper;

Caper::grant_to( 'author' )
  ->caps_for( [ 'post', 'page' ] );

Caper::grant_to( 'contributor' )
  ->caps_for( [ 'post', 'category' ] );

Caper::deny_to( 'editor' )
  ->caps_for( [ 'post', 'page' ] )
  ->except( 'edit_posts' );

Caper::deny_to( 'administrator' )
  ->caps_for( [ 'page', 'category' ] )
  ->only( [ 'edit_posts', 'edit_published_posts', 'manage_terms' ] );
```

Capabilities also can be granted or denied to all roles in one shot:

```php
use Mantle\Caper;

Caper::grant_to_all()->primitives( 'moderate_comments' );
Caper::deny_to_all()->primitives( 'activate_plugins' );
```

The `grant_to_all()` and `deny_to_all()` methods can be combined with the
`then_grant_to()` and `then_deny_to()` methods to "reset" capabilities across
roles before systematically redistributing them. For example:

```php
use Mantle\Caper;

Caper::grant_to_all()
  ->caps_for( 'post' )
  ->then_deny_to( [ 'subscriber', 'contributor' ] );

Caper::deny_to_all()
  ->caps_for( 'category' )
  ->then_grant_to( 'administrator' );
```

Internally, the `then_grant_to()` and `then_deny_to()` methods create new
`Caper` instances that combine the newly supplied roles and previously supplied
primitives or object types.

Because each `Caper` instance modifies user capabilities by adding a filter to
`user_has_cap`, the second of two created instances will apply its distribution
of capabilities after the first instance.

The priority of the `user_has_cap` filter for any `Caper` instance can be
modified with the `at_priority` method:

```php
use Mantle\Caper;

Caper::grant_to( 'editor' )->primitives( 'manage_options' )->at_priority( 99 );
```

## Ensuring unique capability types

`Caper` does not attempt to determine whether the post type or taxonomy
capabilities it distributes are unique to that object type.

For example:

```php
use Mantle\Caper;

\register_post_type(
  'review',
  [
    // ...
    'capability_type' => 'post',
  ]
);

Caper::deny_to( 'editor' )->caps_for( 'review' );
```

will also deny editors capabilities for the `post` post type. Registering post
types with distinct `capability_type` arguments and taxonomies with `capability`
argument arrays is recommended:

```php
\register_post_type(
  'review',
  [
    // ...
    'capability_type' => 'review',
  ]
);

\register_taxonomy(
  'rating',
  'review',
  [
    // ...
    'capabilities' => [
      'manage_terms' => 'manage_ratings',
      'edit_terms'   => 'edit_ratings',
      'delete_terms' => 'delete_ratings',
      'assign_terms' => 'assign_ratings',
    ]
  ]
);
```
