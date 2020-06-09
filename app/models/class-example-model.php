<?php
/**
 * Example_Model class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Framework\Database\Model\Post;

/**
 * Example_Model Model.
 */
class Example_Model extends Post {
	/**
	 * Post Type
	 *
	 * @var string
	 */
	public static $object_name = 'example-model';
}
