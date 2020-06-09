<?php
/**
 * Post class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Framework\Database\Model\Post as Base_Post;

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
}
