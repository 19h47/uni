<?php // phpcs:ignore
/**
 * Class ProductTag
 *
 * @package UNI
 * @subpackage UNI/Core
 */

namespace UNI\Core;

use UNI\Core\{ Transients };


/**
 * Transients class
 */
class ProductTag {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'edit_product_tag', array( $this, 'edit' ), 10, 2 );
	}


	/**
	 * Edit
	 *
	 * @param int $term_id Term ID.
	 * @param int $tt_id Term taxonomy ID.
	 *
	 * @return void
	 */
	public function edit( int $term_id, int $tt_id ) : void {
		$products = Transients::products();

		foreach ( $products as $product ) {
			delete_transient( 'uni_product_variations_' . $product->id );
		}
	}
}
