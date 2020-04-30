<?php // phpcs:ignore
/**
 * Product post
 *
 * PHP version 7.3.8
 *
 * @package uni
 */

namespace UNI\Models;

use Timber\{ Timber, Post };
use WC_Product;
use UNI\Core\{ Transients };

/**
 * Product post
 */
class ProductPost extends Post {

	/**
	 * Node type
	 *
	 * @var string $node_type
	 */
	public $node_type = 'HorizontalPage';


	/**
	 * Construct
	 *
	 * @param mixed $pid Post object.
	 */
	public function __construct( $pid = null ) {
		parent::__construct( $pid );
	}


	/**
	 * Product
	 *
	 * @return WC_Product
	 */
	public function product() : WC_Product {
		return wc_get_product( $this->id );
	}


	/**
	 * Attributes
	 *
	 * @return array
	 */
	public function attributes() : array {
		return $this->product->get_attributes();
	}


	/**
	 * Product variations
	 *
	 * @return array
	 */
	public function product_variations() : array {
		return Transients::product_variations( $this->id );
	}


	/**
	 * Related products
	 *
	 * @return array
	 */
	public function related_products() : array {
		$transient = get_transient( 'uni_related_products_' . $this->id );

		if ( $transient ) {
			return $transient;
		}

		$related_ids = wc_get_related_products( $this->id, -1 );

		$related_products = Timber::get_posts( $related_ids, 'UNI\Models\ProductPost' );

		set_transient( 'uni_related_products_' . $this->id, $related_products );

		return $related_products ? $related_products : array();
	}



	/**
	 * Get HTML to show product stock.
	 *
	 * @see https://github.com/woocommerce/woocommerce/blob/e1aaa6c63c02bd6197d4b40fce317cf8d424d36b/includes/wc-template-functions.php#L3392
	 * @return string string
	 */
	public function stock_html() : string {
		return wc_get_stock_html( $this->product() );
	}



	/**
	 * Add to cart form action
	 *
	 * @return string
	 */
	public function add_to_cart_form_action() : string {
		return apply_filters( 'woocommerce_add_to_cart_form_action', $this->product->get_permalink() );
	}


	/**
	 * Add to cart text
	 *
	 * @return string
	 */
	public function add_to_cart_text() : string {
		return $this->product->single_add_to_cart_text();
	}


	/**
	 * Quantity input
	 *
	 * @see https://github.com/woocommerce/woocommerce/blob/master/includes/wc-template-functions.php#L1668
	 * @return string
	 */
	public function quantity_input() : string {
		return woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $this->product->get_min_purchase_quantity(), $this->product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $this->product->get_max_purchase_quantity(), $this->product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $this->product->get_min_purchase_quantity(),
			),
			$this->product,
			false
		);
	}
}
