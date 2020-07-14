Model Factory
=============

Models can use factories to automatically generate data for your application. They're incredibly useful to get 'real' data in place without the bloat of a database dump.

Factories are defined in the `database/factories` folder of the application. You can use [`Faker`](https://github.com/fzaninotto/Faker) to generate data easily.

# Defining Factories for a Model
A factory can be registered directly to a model.

```php
/**
 * Factory definition.
 *
 * @var \Mantle\Framework\Database\Factory\Factory $factory
 */
$factory->define(
	\App\Models\Post::class, // phpcs:ignore
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
