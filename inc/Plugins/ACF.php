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
}

