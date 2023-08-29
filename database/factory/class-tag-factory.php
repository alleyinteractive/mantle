<?php
/**
 * Tag Factory
 *
 * @package Mantle
 */

// phpcs:disable Squiz.Commenting.FunctionComment.MissingParamComment

namespace App\Database\Factory;

use Mantle\Support\Str;
use App\Models\Tag;

/**
 * Tag Factory
 *
 * @extends \Mantle\Database\Factory\Term_Factory<\App\Models\Tag>
 */
class Tag_Factory extends \Mantle\Database\Factory\Term_Factory {
	/**
	 * Model to use when creating objects.
	 *
	 * @var class-string<\Mantle\Database\Model\Model>
	 */
	protected string $model = Tag::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array {
		return [
			'name'        => $this->faker->sentence,
			'description' => $this->faker->paragraph,
			'taxonomy'    => 'tag',
		];
	}
}
