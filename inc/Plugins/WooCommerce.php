<?php // phpcs:ignore
/**
 *
 *
 * @package uni
 * @subpackage UNI/Plugins/WooCommerce
 */

namespace UNI\Plugins;

use WC_AJAX, WC_Product;
use Timber\{ Timber, Helper };

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

		// Before shop loop item.
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

		// Before shop loop item title.
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		// Shop loop item title.
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_product_title' ), 10 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_price' ), 15 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_product_colors' ), 20 );

		// After shop loop title.
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'template_loop_product_thumbnail' ), 10 );

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

		add_action( 'woocommerce_cart_actions', array( $this, 'cart_actions' ), 10 );

		add_action( 'woocommerce_before_cart', array( $this, 'output_before_cart_wrapper' ), 15 );

		// before cart table.
		add_action( 'woocommerce_before_cart_table', array( $this, 'before_cart_table' ), 10 );

		// after cart.
		add_action( 'woocommerce_after_cart', array( $this, 'output_after_cart_wrapper' ), 10 );

		// checkout fields.
		add_filter( 'woocommerce_checkout_fields', array( $this, 'checkout_fields' ) );
		add_filter( 'woocommerce_default_address_fields', array( $this, 'address_fields' ) );

		add_filter( 'woocommerce_form_field_args', array( $this, 'form_field_args' ), 10, 3 );

		add_filter( 'woocommerce_order_button_text', array( $this, 'order_button_text' ), 10, 1 );

		// cart_is empty.
		remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
		add_action( 'woocommerce_cart_is_empty', array( $this, 'empty_cart_message' ), 10 );

		add_filter( 'woocommerce_product_options_advanced', array( $this, 'product_options_advanced' ), 10 );
		add_action( 'woocommerce_process_product_meta', array( $this, 'update_meta_data' ), 10, 1 );

		add_action( 'woocommerce_single_product_price', 'woocommerce_template_single_price', 10, 1 );
	}


	/**
	 * Show notice if cart is empty.
	 *
	 * @return void
	 */
	public function empty_cart_message() {
		Timber::render( 'partials/empty-cart-message.html.twig' );
	}


	/**
	 * Pay order button text
	 *
	 * @param string $text Order button text.
	 *
	 * @return string $text
	 */
	public function order_button_text( string $text ) : string {
		$text = __( 'Confirm your order', 'uni' );

		return $text;
	}


	/**
	 * Form fields args
	 *
	 * @param array  $args Arguments.
	 * @param string $key key.
	 * @param string $value (default: null).
	 *
	 * @see https://github.com/woocommerce/woocommerce/blob/trunk/plugins/woocommerce/includes/wc-template-functions.php#L2749
	 *
	 * @return array $args
	 */
	public function form_field_args( array $args, string $key, $value ) : array {
		$args['class'][] = 'Input';

		return $args;
	}

	/**
	 * Checkout fields
	 *
	 * @param array $fields Array of fields.
	 *
	 * @see https://github.com/woocommerce/woocommerce/blob/trunk/plugins/woocommerce/includes/class-wc-checkout.php#L267
	 *
	 * @return array $fields
	 */
	public function checkout_fields( array $fields ) : array {
		// order.
		$fields['order']['order_comments']['label']       = __( 'Note', 'uni' );
		$fields['order']['order_comments']['placeholder'] = '';

		// billing.
		$fields['billing']['billing_email']['label'] = __( 'Email address', 'uni' );
		$fields['billing']['billing_phone']['class'] = array( 'form-row-first' );
		$fields['billing']['billing_email']['class'] = array( 'form-row-last' );

		$fields['billing']['billing_company']['label']    = __( 'Company', 'uni' );
		$fields['billing']['billing_country']['label']    = __( 'Country', 'uni' );
		$fields['billing']['billing_country']['priority'] = 70;

		// shipping.
		$fields['shipping']['shipping_last_name']['priority'] = 10;
		$fields['shipping']['shipping_last_name']['class']    = array( 'form-row-first' );

		$fields['shipping']['shipping_first_name']['priority'] = 20;
		$fields['shipping']['shipping_first_name']['class']    = array( 'form-row-last' );

		$fields['shipping']['shipping_address_1']['priority'] = 40;
		$fields['shipping']['shipping_postcode']['priority']  = 60;
		$fields['shipping']['shipping_city']['priority']      = 65;
		$fields['shipping']['shipping_country']['priority']   = 70;

		$fields['shipping']['shipping_company']['label'] = __( 'Company', 'uni' );
		$fields['shipping']['shipping_country']['label'] = __( 'Country', 'uni' );

		return $fields;
	}


	/**
	 * Address fields
	 *
	 * @param array $address_fields Array of fields address.
	 *
	 * @see https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
	 * @return array $address_fields
	 */
	public function address_fields( array $address_fields ) : array {
		$address_fields['address_1']['label']       = __( 'Address', 'uni' );
		$address_fields['address_1']['placeholder'] = '';

		unset( $address_fields['address_2'] );

		return $address_fields;
	}


	/**
	 * Cart actions
	 *
	 * @see https://github.com/woocommerce/woocommerce/blob/trunk/plugins/woocommerce/templates/cart/cart.php#L150
	 *
	 * @return void
	 */
	public function cart_actions() : void {

		Timber::render(
			'components/button.html.twig',
			array(
				'label'      => esc_html__( 'Return to shop', 'uni' ),
				'tag'        => 'a',
				'classes'    => array( 'me-12px', 'd-inline-block', 'w-100', 'w-md-auto', 'button', 'wc-backward' ),
				'attributes' => array(
					'href' => esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ),
				),
			)
		);

		Timber::render(
			'components/button.html.twig',
			array(
				'type'       => 'submit',
				'label'      => esc_html__( 'Update cart', 'uni' ),
				'classes'    => array( 'w-100', 'w-md-auto', 'mt-12px', 'mt-md-0' ),
				'attributes' => array(
					'name'  => 'update_cart',
					'value' => __( 'Update cart', 'uni' ),
				),
			)
		);
	}



	/**
	 * Before cart table
	 *
	 * @return void
	 */
	public function before_cart_table() : void {
		Timber::render(
			'partials/page-title.html.twig',
			array(
				'classes' => array( 'text-center', 'mb-20px', 'text-md-start' ),
				'title'   => get_the_title(),
			)
		);
	}


	/**
	 * Output before cart wrapper
	 *
	 * @return void
	 */
	public function output_before_cart_wrapper() : void {
		echo '<div class="d-md-flex">';
	}


	/**
	 * Output before cart wrapper
	 *
	 * @return void
	 */
	public function output_after_cart_wrapper() : void {
		echo '</div>';
	}


	/**
	 * Gallery thumbnail size
	 *
	 * @return array
	 */
	public function gallery_thumbnail_size() : array {
		return array( 1600, 1050 );
	}


	/**
	 * Add to cart fragments
	 *
	 * @param array $fragments Array of fragments.
	 *
	 * @see https://github.com/woocommerce/woocommerce/blob/trunk/plugins/woocommerce/includes/class-wc-ajax.php#L189
	 *
	 * @return array $fragments
	 */
	public function add_to_cart_fragments( array $fragments ) : array {
		$fragments['span.js-cart-contents-count'] = '<span class="js-cart-contents-count lh-none ms-auto">(' . WC()->cart->get_cart_contents_count() . ')</span>';

		return $fragments;
	}


	/**
	 * AJAX add to cart
	 *
	 * @return void
	 */
	public function add_to_cart() : void {
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
				'upcoming'   => get_post_meta( $product->get_id(), '_upcoming', true ),
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
			'woocommerce/loop/thumbnail.html.twig',
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
	public function template_single_product_content() : void {
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


	/**
	 * Product options advanced
	 *
	 * @return void
	 */
	public function product_options_advanced() : void {
		$args = array(
			'id'    => '_upcoming',
			'value' => get_post_meta( get_the_ID(), '_upcoming', true ),
			'label' => __( 'Upcoming Product', 'uni' ),
		);

		echo '<div class="options_group upcoming">';

		woocommerce_wp_checkbox( $args );

		echo '</div>';

		do_action( 'woocommerce_product_options_upcoming' );
	}


	/**
	 * Update meta data
	 *
	 * @param int $post_id Post id.
	 *
	 * @return void
	 */
	public function update_meta_data( int $post_id ) : void {

		$upcoming = isset( $_POST['_upcoming'] ) ? sanitize_text_field( wp_unslash( $_POST['_upcoming'] ) ) : '';

		update_post_meta( $post_id, '_upcoming', $upcoming );
	}

}
