<?php
/**
 * Category class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Database\Model\Relations\Has_Many;
use Mantle\Database\Model\Term;

/**
 * Category Model.
 */
class Category extends Term {
	/**
	 * Taxonomy Name
	 *
	 * @var string
	 */
	public static $object_name = 'category';

	/**
	 * Retrieve the category's posts.
	 *
	 * @return Has_Many
	 */
	public function posts(): Has_Many {
		return $this->has_many( Post::class );
	}
}
