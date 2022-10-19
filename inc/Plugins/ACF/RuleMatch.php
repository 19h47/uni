<?php // phpcs:ignore
/**
 * RuleMatch
 *
 * @package uni
 * @subpackage UNI/Plugins/WooCommerce
 */

namespace UNI\Plugins\ACF;

use WP_Post;

/**
 * Rule Match
 */
class RuleMatch {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'acf/location/rule_match/page_type', array( $this, 'rule_match_page_type' ), 20, 3 );
	}


	/**
	 * Rule match page type
	 *
	 * @param bool  $match   The true / false variable which must be returned.
	 * @param array $rule    The current rule that you are matching against. This is an array with keys for ‘param’, ‘operator’, ‘value’.
	 * @param array $options An array of data about the current edit screen (post_id, page_template, post_type, etc). This array will also include any data posted in an ajax call (ajax calls are made on a post / page when you change the category, page_template, etc).
	 *
	 * @return bool $match
	 */
	public function rule_match_page_type( bool $match, array $rule, array $options ) : bool {
		if ( empty( $options['post_id'] ) ) {
			return $match;
		}

		$post = get_post( $options['post_id'] );

		if ( 'front_page' === $rule['value'] ) {
			$front_page   = (int) get_option( 'page_on_front' );
			$translations = pll_get_post_translations( $front_page );

			switch ( $rule['operator'] ) {
				case '==':
					$match = in_array( $post->ID, $translations, true );

					break;

				case '!=':
					$match = ! in_array( $post->ID, $translations, true );

					break;
			}
		}

		if ( 'posts_page' === $rule['value'] ) {
			$posts_page   = (int) get_option( 'page_for_posts' );
			$translations = pll_get_post_translations( $posts_page );

			switch ( $rule['operator'] ) {
				case '==':
					$match = in_array( $post->ID, $translations, true );
					break;

				case '!=':
					$match = ! in_array( $post->ID, $translations, true );
					break;
			}
		}

		return $match;
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
