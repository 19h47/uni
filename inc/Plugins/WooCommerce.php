<?php // phpcs:ignore
/**
 *
 *
 * @package uni
 * @subpackage UNI/Plugins/WooCommerce
 */

namespace UNI\Plugins;

use WC_AJAX;
use Timber\{ Timber };

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
		add_filter( 'woocommerce_get_related_product_cat_terms', '__return_empty_array', 10, 2 );

		// Single product
		// Summary.
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

		// Content.
		add_action( 'woocommerce_single_product_content', array( $this, 'template_single_product_content' ), 20 );

		// Meta.
		add_action( 'woocommerce_single_product_meta', array( $this, 'template_product_colors' ), 10 );
		add_action( 'woocommerce_single_product_meta', 'woocommerce_template_single_meta', 40 );

		// Add to cart.
		add_action( 'woocommerce_single_product_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );

		// After single product summary.
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		// Loop
		// Before shop loop item.
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

		// Before shop loop item title.
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		// Shop loop title.
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_product_colors' ), 15 );

		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_product_title' ), 10 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_price' ), 15 );

		// After shop loop title.
		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'template_loop_product_thumbnail' ), 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

		// After shop loop item.
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		// Before main content.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// After main content.
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Before shop loop.
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		add_action( 'wp_ajax_uni_add_to_cart', array( $this, 'add_to_cart' ) );
		add_action( 'wp_ajax_nopriv_uni_add_to_cart', array( $this, 'add_to_cart' ) );

		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
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
	 * AJAX add to cart
	 *
	 * @return void
	 */
	public function add_to_cart() {
		check_ajax_referer( 'security', 'nonce' );

		if ( ! isset( $_POST['product_id'] ) ) {
			return;
		}

		ob_start();

		$product_id     = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity       = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
		$variation_id   = absint( $_POST['variation_id'] );
		$validation     = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		$product_status = get_post_status( $product_id );

		if ( $validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id ) && 'publish' === $product_status ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id );

			if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
				wc_add_to_cart_message( array( $product_id => $quantity ), true );
			}

			WC_AJAX::get_refreshed_fragments();
		} else {

			$data = array(
				'error'       => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
			);

			echo wp_send_json( $data ); // phpcs:ignore
		}

		wp_die();
	}


	/**
	 * Show the product title in the product loop.
	 *
	 * @return void
	 */
	public function template_loop_product_title() : void {
		global $product;

		Timber::render( 'woocommerce/loop/product-title.html.twig', array( 'title' => get_the_title( $product->get_id() ) ) );
	}

	/**
	 * Template loop price
	 *
	 * @return void
	 */
	public function template_loop_price() : void {
		global $product;

		Timber::render(
			'woocommerce/loop/price.html.twig',
			array(
				'price_html' => $product->get_price_html(),
				'render'     => is_product_category() || is_shop(),
			)
		);
	}


	/**
	 * Template loop product thumbnail
	 *
	 * @return void
	 */
	public function template_loop_product_thumbnail() : void {
		global $product;

		Timber::render(
			'woocommerce/loop/product-thumbnail.html.twig',
			array(
				'product'    => Timber::get_post( $product->get_id(), 'UNI\Models\ProductPost' ),
				'is_product' => is_product(),
			)
		);
	}


	/**
	 * Template single product content
	 *
	 * @return void
	 */
	public function template_single_product_content() {
		the_content();
	}


	/**
	 * Product colors
	 *
	 * @return void
	 */
	public function template_product_colors() : void {
		global $product;

		Timber::render(
			'partials/product-colors.html.twig',
			array(
				'render'  => is_product(),
				'product' => Timber::get_post( $product->get_id(), 'UNI\Models\ProductPost' ),
			)
		);
	}
}

