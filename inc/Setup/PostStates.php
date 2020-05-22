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
		add_filter( 'display_post_states', array( $this, 'terms_post_state' ), 10, 2 );
	}

	/**
	 * This always shows the current post status in the labels.
	 *
	 * @param array   $states current states.
	 * @param WP_Post $post current post object.
	 *
	 * @return array $states
	 */
	public function terms_post_state( array $states, WP_Post $post ) {
		$languages = pll_languages_list( array( 'hide_empty' => false ) );

		foreach ( $languages as $lang ) {
			$terms_page = (int) get_option( 'terms_page_' . $lang );

			if ( $post->ID === $terms_page ) {
				$states[] = __( 'Terms & Conditions Page', 'uni' );
			}
		}

		return $states;
	}
}
