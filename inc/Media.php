<?php // phpcs:ignore
/**
 * Media
 *
 * @package WordPress
 * @subpackage UNI
 */

namespace UNI;

/**
 * Media
 */
class Media {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_image_size( 'size-600', 600 );
		add_image_size( 'size-800', 800 );
		add_image_size( 'size-1400', 1400 );
		add_image_size( 'size-1600', 1600 );
		add_image_size( 'size-1720', 1720 );
		add_image_size( 'size-2400', 2400 );
	}
}
