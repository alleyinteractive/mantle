<?php
/**
 * Category class file.
 *
 * @package App\Models
 */

namespace App\Models;

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
}
