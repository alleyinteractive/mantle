<?php
/**
 * Tag class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Database\Model\Term;

/**
 * Tag Model.
 */
class Tag extends Term {
	/**
	 * Taxonomy Name
	 *
	 * @var string
	 */
	public static $object_name = 'post_tag';
}
