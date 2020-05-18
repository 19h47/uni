<?php // phpcs:ignore
/**
 * Post States
 *
 * @package uni
 */

namespace UNI\Setup;

use WP_Post;

/**
 * Supports
 */
class PostStates {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'display_post_states', array( $this, 'display' ), 10, 2 );
	}

	/**
	 * This always shows the current post status in the labels.
	 *
	 * @param array   $states current states.
	 * @param WP_Post $post current post object.
	 *
	 * @return array $states
	 */
	function display( array $states, WP_Post $post ) {

		$terms_page = (int) get_option( 'terms_page' );

		if ( $post->ID !== $terms_page ) {
			return $states;
		}

		$states['terms'] = __( 'Terms & Conditions Page', 'uni' );

		return $states;
	}
}
