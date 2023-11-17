<?php
/**
 * Post class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Database\Model\Post as Base_Post;
use Mantle\Database\Model\Relations\Has_Many;

/**
 * Post Model.
 */
class Post extends Base_Post {
	/**
	 * Post Type
	 *
	 * @var string
	 */
	public static $object_name = 'post';

	/**
	 * Retrieve categories on the post.
	 *
	 * @return Has_Many
	 */
	public function category() {
		return $this->has_many( Category::class );
	}

	/**
	 * Retrieve tags on the post.
	 *
	 * @return Has_Many
	 */
	public function tags(): Has_Many {
		return $this->has_many( Tag::class );
	}
}
