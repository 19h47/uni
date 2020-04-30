<?php // phpcs:ignore
/**
 * Class Transients
 *
 * @package UNI
 * @subpackage UNI/Core
 */

namespace UNI\Core;

use Timber\{ Timber };

/**
 * Transients class
 */
class Transients {

	/**
	 * Products
	 *
	 * @return array $transient
	 */
	public static function products() : array {
		$transient = get_transient( 'uni_products' );

		if ( $transient ) {
			return $transient;
		}

		$products = Timber::get_posts(
			array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'no_found_rows'  => true,
			)
		);

		set_transient( 'uni_products', $products );

		return $products;
	}


	public static function product_variations( int $id ) : array {
		$transient = get_transient( 'uni_product_variations_' . $id );

		if ( $transient ) {
			return $transient;
		}

		$products    = Timber::get_posts( get_field( 'product_variations', $id ) );
		$product_tag = get_the_terms( $id, 'product_tag' );
		$variations  = array();

		if ( ! is_array( $product_tag ) ) {
			return array();
		}

		// Current variation.
		$variations[] = array(
			'link'    => get_permalink( $id ),
			'color'   => get_field( 'color', 'product_tag_' . $product_tag[0]->term_id ),
			'current' => true,
		);

		foreach ( $products as $p ) {
			$p_tag = get_the_terms( $p->id, 'product_tag' );

			if ( ! is_array( $p_tag ) ) {
				continue;
			}

			$variations[] = array(
				'link'    => $p->link(),
				'color'   => get_field( 'color', 'product_tag_' . $p_tag[0]->term_id ),
				'current' => false,
			);
		}

		set_transient( 'uni_product_variations_' . $id, $variations );

		return $variations;
	}
}
