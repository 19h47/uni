<?php // phpcs:ignore
/**
 * Class ProjectCat
 *
 * PHP version 7.3.8
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package UNI
 */

namespace UNI\Core;

/**
 * ProjectCat class
 *
 */
class ProjectCat {


	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}


	/**
	 * Register taxonomy
	 *
	 * @return void
	 */
	public function register_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Categories', 'project category general name', 'uni' ),
			'singular_name'              => _x( 'Category', 'project category singular name', 'uni' ),
			'search_items'               => __( 'Search Categories', 'uni' ),
			'all_items'                  => __( 'All Categories', 'uni' ),
			'popular_items'              => __( 'Popular Categories', 'uni' ),
			'parent_item'                => __( 'Parent Category', 'uni' ),
			'parent_item_colon'          => __( 'Parent Category:', 'uni' ),
			'edit_item'                  => __( 'Edit Category', 'uni' ),
			'view_item'                  => __( 'View Category', 'uni' ),
			'update_item'                => __( 'Update Category', 'uni' ),
			'add_new_item'               => __( 'Add New Category', 'uni' ),
			'new_item_name'              => __( 'New Category Name', 'uni' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'uni' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'uni' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'uni' ),
			'not_found'                  => __( 'No categories found.', 'uni' ),
			'no_terms'                   => __( 'No Categories', 'uni' ),
			'items_list_navigation'      => __( 'Categories list navigation', 'uni' ),
			'items_list'                 => __( 'Categories list', 'uni' ),
			/* translators: Category heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'project category', 'uni' ),
			'back_to_items'              => __( '&larr; Back to Categories', 'uni' ),
		);

		$args = array(
			'labels'             => $labels,
			'hierarchical'       => false,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_in_quick_edit' => false,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
		);
		register_taxonomy( 'project_cat', array( 'project' ), $args );
	}
}
