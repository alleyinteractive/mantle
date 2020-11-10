# Model Factory

- [Model Factory](#model-factory)
	- [Defining Factories for a Model](#defining-factories-for-a-model)
- [Faking Blocks](#faking-blocks)
	- [Registering the Provider](#registering-the-provider)
	- [Generating Blocks](#generating-blocks)

Models can use factories to automatically generate data for your application.
They're incredibly useful to get 'real' data in place without the bloat of a
database dump.

Factories are defined in the `database/factories` folder of the application. You
can use [`Faker`](https://github.com/fzaninotto/Faker) to generate data easily.

## Defining Factories for a Model
A factory can be registered directly to a model.

```php
/**
 * Factory definition.
 *
 * @var \Mantle\Framework\Database\Factory\Factory $factory
 */
$factory->define(
  \App\Models\Post::class,
  function ( Faker $faker ) {
    return [
      'post_title'   => $faker->sentence,
      'post_content' => $faker->paragraph,
      'post_status'  => 'publish',
      'post_type'    => 'post',
    ];
  }
);
```

# Faking Blocks
In addition to faking normal content, Mantle includes a block provider for
faking Gutenberg blocks.

## Registering the Provider
To use the provider, register the provider with Faker

```php
use Mantle\Framework\Faker\Faker_Provider;

$factory->define(
  \App\Models\Post::class,
  function ( Faker $faker ) {
		$this->faker->addProvider( new Faker_Provider( $this->faker ) );

		// ...
  }
);
$this->faker->addProvider( new Faker_Provider( $this->faker ) );
```

## Generating Blocks
Use the `block` method on a Faker instance to generate a block. You can
optionally include attributes and content.

```php
$faker->block(
	'namespace/block',
	'The Content',
	[
		'exampleAttr' => true,
		'another' => false,
	]
);
```

Which would produce this:

```html
<!-- wp:namespace/block {"exampleAttr":true,"another":false} -->
The Content
<!-- /wp:namespace/block -->
```
