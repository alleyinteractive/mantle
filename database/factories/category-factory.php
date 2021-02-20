<?php
/**
 * Category Factory
 *
 * @package Mantle
 */

// phpcs:disable Squiz.Commenting.FunctionComment.MissingParamComment

namespace App\Factory;

use Faker\Generator as Faker;
use Mantle\Database\Model\Term;

/**
 * Factory definition.
 *
 * @var \Mantle\Database\Factory\Factory $factory
 */
$factory->define(
	Term::class, // phpcs:ignore
	function ( Faker $faker ) {
		return [
			'name'        => $faker->sentence,
			'description' => $faker->paragraph,
			'taxonomy'    => 'category',
			'object_type' => 'post',
		];
	}
);
