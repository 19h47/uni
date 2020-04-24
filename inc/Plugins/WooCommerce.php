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

		add_filter( 'woocommerce_product_related_posts_query', array( $this, 'related_product_query' ), 10, 3 );

		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
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


	/**
	 * Return a list of products in same category
	 *
	 * @param array $query Current query.
	 * @param int   $product_id  Product ID.
	 * @param array $args Array of arguments.
	 *
	 * @see https://github.com/woocommerce/woocommerce/blob/master/includes/data-stores/class-wc-product-data-store-cpt.php#L1244
	 */
	public function related_product_query( array $query, int $product_id, array $args ) : array {
		// @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
		$args['categories'] = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'ids' ) );

		return $query;
	}
}

