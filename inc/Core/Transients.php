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


	/**
	 * Product colors
	 *
	 * @param int $id Post id.
	 *
	 * @return array
	 */
	public static function product_colors( int $id ) : array {
		$transient = get_transient( 'uni_product_colors_' . $id );

		if ( $transient ) {
			return $transient;
		}

		$product_colors = get_field( 'product_colors', $id );

		if ( ! $product_colors ) {
			set_transient( 'uni_product_colors_' . $id, array() );

			return array();
		}

		$products = Timber::get_posts( $product_colors );

		$product_tag = get_the_terms( $id, 'product_tag' );
		$variations  = array();

		if ( ! is_array( $product_tag ) || ! is_array( $products ) ) {
			return $variations;
		}

		// Current variation.
		$variations[] = array(
			'link'      => get_permalink( $id ),
			'color'     => get_field( 'color', 'product_tag_' . $product_tag[0]->term_id ),
			'current'   => true,
			'thumbnail' => get_post_thumbnail_id( $id ),
			'hover'     => get_field( 'image_hover', $id ),
			'title'     => get_the_title( $id ),
		);

		foreach ( $products as $p ) {
			$p_tag = get_the_terms( $p->id, 'product_tag' );

			if ( ! is_array( $p_tag ) ) {
				continue;
			}

			$variations[] = array(
				'link'      => $p->link(),
				'color'     => get_field( 'color', 'product_tag_' . $p_tag[0]->term_id ),
				'current'   => false,
				'thumbnail' => get_post_thumbnail_id( $p->id ),
				'packshot'  => get_field( 'image_packshot', $p->id ),
				'title'     => $p->get_title(),
			);
		}

		set_transient( 'uni_product_colors_' . $id, $variations );

		return $variations;
	}
}
