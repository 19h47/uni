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
		$attributes = array();

		foreach ( $this->product->get_attributes() as $attribute ) {
			if ( $attribute->get_visible() ) {
				$options = array();

				foreach ( $attribute->get_options() as $option ) {
					$search  = array( 'd', 'mm', 'ø', '⌀', 'h');
					$replace = array( '<span>d</span>', '<span>mm</span>', '<span>⌀</span>', '<span>⌀</span>', '<span>h</span>' );

					$options[] = str_replace( $search, $replace, $option );
				}

				$attributes[] = array(
					'name'    => $attribute->get_name(),
					'options' => $options,
				);
			}
		}

		return $attributes;
	}


	/**
	 * Product colors
	 *
	 * @return array
	 */
	public function product_colors() : array {
		return Transients::product_colors( $this->id );
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

		$related_ids = wc_get_related_products( $this->id, 10 );

		$related_products = Timber::get_posts( $related_ids, 'UNI\Models\ProductPost' );

		set_transient( 'uni_related_products_' . $this->id, $related_products );

		return $related_products ? $related_products : array();
	}


	/**
	 * Upcoming
	 *
	 * Return either product is upcoming or not
	 *
	 * @return bool
	 */
	public function upcoming() {
		return get_post_meta( $this->id, '_upcoming', true );
	}
}
