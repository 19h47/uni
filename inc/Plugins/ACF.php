<?php // phpcs:ignore
/**
 * ACF
 *
 * @package uni
 * @subpackage UNI/Plugins/WooCommerce
 */

namespace UNI\Plugins;

use WP_Post;

/**
 * WordPress
 */
class ACF {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'acf/fields/relationship/query/name=product_colors', array( $this, 'product_colors_query' ), 10, 3 );
		add_filter( 'acf/fields/relationship/result/name=product_colors', array( $this, 'product_colors_result' ), 10, 4 );
		add_filter( 'acf/fields/post_object/result/name=product_link', array( $this, 'product_colors_result' ), 10, 4 );
		add_filter( 'acf/location/rule_match/page_type', array( $this, 'rule_match_page_type' ), 20, 3 );

		add_action( 'init', array( $this, 'add_projects_options_page' ), 0 );
	}


	/**
	 * Product colors query
	 *
	 * @param array $args The WP_Query args used to find choices.
	 * @param array $field The field array containing all attributes & settings.
	 * @param int   $post_id  The current post ID being edited.
	 *
	 * @return array $args
	 */
	public function product_colors_query( array $args, array $field, int $post_id ) {
		$args['post__not_in'] = array( $post_id );

		return $args;
	}


	/**
	 * Product colors result
	 *
	 * @param string  $title The text displayed for this post object
	 * @param WP_Post $post The post object
	 * @param array   $field The field array containing all attributes & settings
	 * @param int     $post_id The current post ID being edited
	 *
	 * @return string $title
	 */
	public function product_colors_result( string $title, WP_Post $post, array $field, int $post_id ) : string {
		$product_tag = get_the_terms( $post, 'product_tag' );

		if ( $product_tag ) {
			$color = get_field( 'color', 'product_tag_' . $product_tag[0]->term_id );

			$title = "<span style=\"display: inline-block; vertical-align: middle; border-radius: 0.1em; width: 1em; height: 1em; background-color: $color;\"></span>&nbsp;" . $title;
		}
		return $title;
	}


	/**
	 * Page on front
	 */
    public function page_on_front( $match ) {

        if ( ! $this->filtered ) {
            add_filter( 'option_page_on_front', array( $this, 'translate_page_on_front' ) );
            // Prevent second hooking
            $this->filtered = true;
        }

        return $match;
    }


	/**
	 * Rule match page type
	 *
	 */
	public function rule_match_page_type( $match, $rule, $options ) {
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
	 * Add coupon options page
	 *
	 * @return void
	 */
	public function add_projects_options_page() {

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

