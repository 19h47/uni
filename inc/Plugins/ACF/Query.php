<?php // phpcs:ignore
/**
 * Query
 *
 * @package uni
 * @subpackage UNI/Plugins/WooCommerce
 */

namespace UNI\Plugins\ACF;

use WP_Post;

/**
 * Query
 */
class Query {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'acf/fields/relationship/query/name=product_colors', array( $this, 'product_colors_query' ), 10, 3 );
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
}
