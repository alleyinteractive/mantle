<?php
/**
 * Example_Post class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Framework\Contracts\Database\Registrable;
use Mantle\Framework\Database\Model\Post;
use Mantle\Framework\Database\Model\Registration\Register_Post_Type;

/**
 * Example_Post Model.
 */
class Example_Post extends Post implements Registrable {
	use Register_Post_Type;

	/**
	 * Arguments to register the model with.
	 *
	 * @return array
	 */
	public static function get_registration_args(): array {
		return [
			'public'                => true,
			'rest_base'             => static::get_object_name(),
			'show_in_rest'          => true,
			'supports'              => [ 'author', 'title', 'editor', 'revisions', 'thumbnail', 'custom-fields', 'excerpt' ],
			'taxonomies'            => [ 'category', 'post_tag' ],
			'labels'                => [
				'name'                     => __( 'Example Post', 'mantle' ),
				'singular_name'            => __( 'Example Post', 'mantle' ),
				'add_new'                  => __( 'Add New Example Post', 'mantle' ),
				'add_new_item'             => __( 'Add New Example Post', 'mantle' ),
				'edit_item'                => __( 'Edit Example Post', 'mantle' ),
				'new_item'                 => __( 'New Example Post', 'mantle' ),
				'view_item'                => __( 'View Example Post', 'mantle' ),
				'view_items'               => __( 'View Example Post', 'mantle' ),
				'search_items'             => __( 'Search Example Post', 'mantle' ),
				'not_found'                => __( 'No Example Post found', 'mantle' ),
				'not_found_in_trash'       => __( 'No Example Post found in Trash', 'mantle' ),
				'parent_item_colon'        => __( 'Parent Example Post:', 'mantle' ),
				'all_items'                => __( 'All Example Post', 'mantle' ),
				'archives'                 => __( 'Example Post Archives', 'mantle' ),
				'attributes'               => __( 'Example Post Attributes', 'mantle' ),
				'insert_into_item'         => __( 'Insert into Example Post', 'mantle' ),
				'uploaded_to_this_item'    => __( 'Uploaded to this Example Post', 'mantle' ),
				'featured_image'           => __( 'Featured Image', 'mantle' ),
				'set_featured_image'       => __( 'Set featured image', 'mantle' ),
				'remove_featured_image'    => __( 'Remove featured image', 'mantle' ),
				'use_featured_image'       => __( 'Use as featured image', 'mantle' ),
				'filter_items_list'        => __( 'Filter Example Post list', 'mantle' ),
				'items_list_navigation'    => __( 'Example Post list navigation', 'mantle' ),
				'items_list'               => __( 'Example Post list', 'mantle' ),
				'item_published'           => __( 'Example Post published.', 'mantle' ),
				'item_published_privately' => __( 'Example Post published privately.', 'mantle' ),
				'item_reverted_to_draft'   => __( 'Example Post reverted to draft.', 'mantle' ),
				'item_scheduled'           => __( 'Example Post scheduled.', 'mantle' ),
				'item_updated'             => __( 'Example Post updated.', 'mantle' ),
				'menu_name'                => __( 'Example Post', 'mantle' ),
			],
		];
	}
}
