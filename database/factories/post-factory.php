<?php
/**
 * Post Factory
 *
 * @package Mantle
 */

// phpcs:disable Squiz.Commenting.FunctionComment.MissingParamComment

namespace App\Factory;

use Faker\Generator as Faker;
use Mantle\Framework\Database\Model\Post;
use Mantle\Framework\Support\Str;

/**
 * Factory definition.
 *
 * @var \Mantle\Framework\Database\Factory\Factory $factory
 */
$factory->define(
	Post::class, // phpcs:ignore
	function ( Faker $faker ) {

		$name = $faker->sentence;
		$slug = Str::slug( $name );

		return [
			'name'    => $name,
			'slug'    => $slug,
			'content' => $faker->paragraph,
		];
	}
);
