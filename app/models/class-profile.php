<?php
/**
 * Profile class file
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Contracts\Database\Registrable;
use Mantle\Database\Model\Post;
use Mantle\Database\Model\Registration\Register_Post_Type;

/**
 * Profile Model.
 */
class Profile extends Post implements Registrable {
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
				'name'                     => __( 'Profiles', '' ),
				'singular_name'            => __( 'Profile', '' ),
				'add_new'                  => __( 'Add New Profile', '' ),
				'add_new_item'             => __( 'Add New Profile', '' ),
				'edit_item'                => __( 'Edit Profile', '' ),
				'new_item'                 => __( 'New Profile', '' ),
				'view_item'                => __( 'View Profile', '' ),
				'view_items'               => __( 'View Profiles', '' ),
				'search_items'             => __( 'Search Profiles', '' ),
				'not_found'                => __( 'No Profiles found', '' ),
				'not_found_in_trash'       => __( 'No Profiles found in Trash', '' ),
				'parent_item_colon'        => __( 'Parent Profile:', '' ),
				'all_items'                => __( 'All Profiles', '' ),
				'archives'                 => __( 'Profile Archives', '' ),
				'attributes'               => __( 'Profile Attributes', '' ),
				'insert_into_item'         => __( 'Insert into Profile', '' ),
				'uploaded_to_this_item'    => __( 'Uploaded to this Profile', '' ),
				'featured_image'           => __( 'Featured Image', '' ),
				'set_featured_image'       => __( 'Set featured image', '' ),
				'remove_featured_image'    => __( 'Remove featured image', '' ),
				'use_featured_image'       => __( 'Use as featured image', '' ),
				'filter_items_list'        => __( 'Filter Profiles list', '' ),
				'items_list_navigation'    => __( 'Profiles list navigation', '' ),
				'items_list'               => __( 'Profiles list', '' ),
				'item_published'           => __( 'Profile published.', '' ),
				'item_published_privately' => __( 'Profile published privately.', '' ),
				'item_reverted_to_draft'   => __( 'Profile reverted to draft.', '' ),
				'item_scheduled'           => __( 'Profile scheduled.', '' ),
				'item_updated'             => __( 'Profile updated.', '' ),
				'menu_name'                => __( 'Profiles', '' ),
			],
		];
	}
}
