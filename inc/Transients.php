<?php // phpcs:ignore
/**
 * Class Transients
 *
 * @package UNI
 * @subpackage UNI/Transients
 */

namespace UNI;

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
}
