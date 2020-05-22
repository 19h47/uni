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

		$languages = pll_languages_list( array( 'hide_empty' => false ) );

		foreach ( $languages as $lang ) {
			add_settings_field(
				'terms_page_' . $lang,
				__( 'Terms & Conditions Page', 'uni' ) . ' (' . ucfirst( $lang ) . ')',
				array( $this, 'page_callback' ),
				'reading',
				'default',
				array(
					'lang' => $lang,
					'type' => 'terms_page_',
				)
			);

			add_settings_field(
				'habitat_page_' . $lang,
				__( 'Habitat Page', 'uni' ) . ' (' . ucfirst( $lang ) . ')',
				array( $this, 'page_callback' ),
				'reading',
				'default',
				array(
					'lang' => $lang,
					'type' => 'habitat_page_',
				)
			);

			add_settings_field(
				'objects_page_' . $lang,
				__( 'Objects Page', 'uni' ) . ' (' . ucfirst( $lang ) . ')',
				array( $this, 'page_callback' ),
				'reading',
				'default',
				array(
					'lang' => $lang,
					'type' => 'objects_page_',
				)
			);

			register_setting( 'reading', 'terms_page_' . $lang );
			register_setting( 'reading', 'habitat_page_' . $lang );
			register_setting( 'reading', 'objects_page_' . $lang );
		}
	}


	/**
	 * Page callback
	 *
	 * @param array $args Arguments.
	 *
	 * @return void
	 */
	public function page_callback( array $args ) : void {
		wp_dropdown_pages(
			array(
				'echo'             => true,
				'selected'         => get_option( $args['type'] . $args['lang'] ), // phpcs:ignore
				'name'             => $args['type'] . $args['lang'], // phpcs:ignore
				'lang'             => $args['lang'], // phpcs:ignore
				'show_option_none' => __( 'Please select a page', 'uni' ), // phpcs:ignore
			)
		);
	}
}
