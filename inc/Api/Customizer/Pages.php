<?php
/**
 * Pages
 *
 * @category Customizer
 * @package  uni
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace UNI\Api\Customizer;

use WP_Customize_Manager;

/**
 * Pages
 */
class Pages {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'customize_register', array( $this, 'register' ), 10, 1 );
	}


	/**
	 * Register
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public function register( WP_Customize_Manager $wp_customize ) {
		// Add pages section.
		$wp_customize->add_section(
			'pages',
			array(
				'title'       => __( 'Pages', 'uni' ),
				'description' => __( 'Pages Settings', 'uni' ),
			)
		);

		$wp_customize->add_setting(
			'objects_page',
			array(
				'capability' => 'edit_theme_options',
				'default'    => '',
				'type'       => 'option',
			)
		);

		$wp_customize->add_control(
			'objects_page',
			array(
				'type'    => 'dropdown-pages',
				'section' => 'pages',
				'label'   => __( 'Objects Page', 'uni' ),
			)
		);

		$wp_customize->add_setting(
			'habitat_page',
			array(
				'capability' => 'edit_theme_options',
				'default'    => '',
				'type'       => 'option',
			)
		);

		$wp_customize->add_control(
			'habitat_page',
			array(
				'type'    => 'dropdown-pages',
				'section' => 'pages',
				'label'   => __( 'Habitat Page', 'uni' ),
			)
		);
	}
}
