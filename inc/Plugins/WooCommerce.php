<?php // phpcs:ignore
/**
 *
 *
 * @package uni
 * @subpackage UNI/Plugins/WooCommerce
 */

namespace UNI\Plugins;

/**
 * WordPress
 */
class WooCommerce {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'woocommerce_gallery_thumbnail_size', array( $this, 'gallery_thumbnail_size' ) );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ), 10, 1 );
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
	}


	/**
	 * Gallery thumbnail size
	 *
	 * @return array
	 */
	public function gallery_thumbnail_size() {
		return array( 1600, 1050 );
	}


	/**
	 * Add to cart fragments
	 *
	 * @param array $fragments Array of fragments.
	 *
	 * @return array $fragments
	 */
	public function add_to_cart_fragments( array $fragments ) {

		$fragments['span.js-cart-contents-count'] = '<span class="js-cart-contents-count">(' . WC()->cart->get_cart_contents_count() . ')</span>';

		return $fragments;
	}
}

