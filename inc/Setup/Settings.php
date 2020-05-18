<?php // phpcs:ignore
/**
 * Settings
 *
 * @package uni
 */

namespace UNI\Setup;

/**
 * Supports
 */
class Settings {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}


	/**
	 * Register settings
	 *
	 * @return void
	 */
	public function register_settings() : void {

		add_settings_field(
			'terms_page',
			__( 'Terms & Conditions Page', 'uni' ),
			array( $this, 'terms_page_callback' ),
			'reading',
		);

		register_setting( 'reading', 'terms_page' );
	}


	/**
	 * Terms page callback
	 *
	 * @return void
	 */
	public function terms_page_callback() : void {
		wp_dropdown_pages(
			array(
				'echo'     => true,
				'selected' => get_option( 'terms_page' ),
				'name'     => 'terms_page',
			)
		);
	}
}
