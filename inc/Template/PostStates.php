<?php // phpcs:ignore
/**
 * Post States
 *
 * @package WordPress
 * @subpackage UNI
 */

namespace UNI\Template;

use WP_Post;

/**
 * PostStates
 */
class PostStates {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'display_post_states', array( $this, 'display_post_states' ), 10, 2 );
	}

	/**
	 * Post states
	 *
	 * @param string[] $post_states An array of post display states.
	 * @param WP_Post  $post        The current post object.
	 *
	 * @see https://developer.wordpress.org/reference/hooks/display_post_states/
	 *
	 * @return array $states
	 */
	public function display_post_states( array $post_states, WP_Post $post ) {
		if ( function_exists( 'pll_languages_list' ) ) {
			$languages = pll_languages_list( array( 'hide_empty' => false ) );

			foreach ( $languages as $lang ) {
				$terms_page = (int) get_option( 'terms_page_' . $lang );

				if ( $post->ID === $terms_page ) {
					$states[] = __( 'Terms & Conditions Page', 'uni' );
				}
			}
		}

		if ( 'templates/about-page.php' === get_post_meta( $post->ID, '_wp_page_template', true ) ) {
			$post_states[] = __( 'About Page', 'uni' );
		}

		if ( 'templates/archive-page.php' === get_post_meta( $post->ID, '_wp_page_template', true ) ) {
			$post_states[] = __( 'Archive Page', 'uni' );
		}

		if ( 'templates/contact-page.php' === get_post_meta( $post->ID, '_wp_page_template', true ) ) {
			$post_states[] = __( 'Contact Page', 'uni' );
		}

		if ( 'templates/horizontal-page.php' === get_post_meta( $post->ID, '_wp_page_template', true ) ) {
			$post_states[] = __( 'Horizontal Page', 'uni' );
		}

		return $post_states;
	}
}
