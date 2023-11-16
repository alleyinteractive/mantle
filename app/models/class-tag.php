<?php
/**
 * Tag class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Database\Model\Relations\Has_Many;
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

	/**
	 * Retrieve the tag's posts.
	 *
	 * @return Has_Many
	 */
	public function posts(): Has_Many {
		return $this->has_many( Post::class );
	}
}
