<?php
/**
 * Category Factory
 *
 * @package Mantle
 */

// phpcs:disable Squiz.Commenting.FunctionComment.MissingParamComment

namespace App\Database\Factory;

use Mantle\Support\Str;
use App\Models\Category;

/**
 * Category Factory
 *
 * @extends \Mantle\Database\Factory\Term_Factory<\App\Models\Category>
 */
class Category_Factory extends \Mantle\Database\Factory\Term_Factory {
	/**
	 * Model to use when creating objects.
	 *
	 * @var class-string
	 */
	protected string $model = Category::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition(): array {
		return [
			'name'        => $this->faker->sentence,
			'description' => $this->faker->paragraph,
			'taxonomy'    => 'category',
		];
	}
}
