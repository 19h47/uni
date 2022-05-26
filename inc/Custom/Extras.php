<?php // phpcs:ignore
/**
 * Extras
 *
 * @package uni
 */

namespace UNI\Custom;

/**
 * Extras.
 */
class Extras {
	/**
	 * Run default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}


	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * Displays the class names for the body element.
	 *
	 * @param array $classes Space-separated string or array of class names to add to the class list.
	 *
	 * @return $classes array
	 */
	public function body_class( $classes ) : array {
		if ( is_front_page() ) {
			$classes[] = 'Front-page';
		}

		if ( ! is_front_page() && ! is_single() ) {
			$classes[] = 'Page';
		}

		if ( is_single() ) {
			$classes[] = 'Single';
		}

		if ( is_archive() ) {
			$classes[] = 'Archive';
		}

		if ( is_singular( 'product' ) ) {
			$classes[] = 'Single-product';
		}

		if ( is_singular( 'project' ) ) {
			$classes[] = 'Single-project';
		}

		// if ( is_cart() ) {
		// $classes[] = 'Cart';
		// }

		return $classes;
	}

}
