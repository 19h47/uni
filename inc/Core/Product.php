<?php // phpcs:ignore
/**
 * Class ProductTag
 *
 * @package UNI
 * @subpackage UNI/Core
 */

namespace UNI\Core;

use UNI\Core\{ Transients };
use WP_Post;


/**
 * Transients class
 */
class Product {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'save_post_product', array( $this, 'save' ), 10, 3 );
	}


	/**
	 * Save
	 *
	 * @param int     $post_ID Post ID.
	 * @param WP_Post $post Post object.
	 * @param bool    $update Whether this is an existing post being updated or not.
	 *
	 * @return void
	 */
	public function save( int $post_ID, WP_Post $post, bool $update ) : void {
		delete_transient( 'uni_product_variations_' . $post_ID );
		delete_transient( 'uni_related_products_' . $post_ID );
	}
}
