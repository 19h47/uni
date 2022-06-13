<?php // phpcs:ignore
/**
 * Init
 *
 * @package uni
 * @subpackage UNI/Plugins/WooCommerce
 */

namespace UNI\Plugins\ACF;

use WP_Post;

/**
 * Init
 */
class Init {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'acf/init', array( $this, 'add_options_pages' ) );
	}

	/**
	 * Add options pages
	 *
	 * @return void
	 */
	public function add_options_pages() {
		if ( function_exists( 'pll_languages_list' ) && function_exists( 'acf_add_options_page' ) ) {
			$languages = pll_languages_list( array( 'hide_empty' => false ) );

			foreach ( $languages as $lang ) {

				acf_add_options_page(
					array(
						'menu_title'  => __( 'Projects Settings', 'uni' ) . ' (' . ucfirst( $lang ) . ')',
						'page_title'  => __( 'Projects Settings', 'uni' ) . ' (' . ucfirst( $lang ) . ')',
						'menu_slug'   => 'projects-settings-' . $lang,
						'parent_slug' => 'edit.php?post_type=project',
						'capability'  => 'edit_posts',
						'post_id'     => 'projects_settings_' . $lang,
					)
				);
			}
		}
	}
}
