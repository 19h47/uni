<?php // phpcs:ignore
/**
 * Menus
 *
 * @package uni
 */

namespace UNI\Setup;

/**
 * Menus
 */
class Menus {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );

	}

	/**
	 * Register nav menus
	 *
	 * @return void
	 */
	public function register_menus() : void {
		register_nav_menus(
			array(
				'main_primary'     => __( 'Main Primary', 'uni' ),
				'main_secondary'   => __( 'Main Secondary', 'uni' ),
				'footer_primary'   => __( 'Footer Primary', 'uni' ),
				'footer_secondary' => __( 'Footer Secondary', 'uni' ),
				'footer_tertiary'  => __( 'Footer Tertiary', 'uni' ),
			)
		);
	}
}
