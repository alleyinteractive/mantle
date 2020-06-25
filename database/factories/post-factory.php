<?php
/**
 * Post Factory
 *
 * @package Mantle
 */

// phpcs:disable Squiz.Commenting.FunctionComment.MissingParamComment

namespace App\Factory;

use App\Models\Post;
use Faker\Generator as Faker;

/**
 * Factory definition.
 *
 * @var \Mantle\Framework\Database\Factory\Factory $factory
 */
$factory->define(
	Post::class, // phpcs:ignore
	function ( Faker $faker ) {
		return [
			'post_title'   => $faker->sentence,
			'post_content' => $faker->paragraph,
			'post_status'  => 'publish',
			'post_type'    => 'post',
		];
	}
);
