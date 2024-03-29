<?php // phpcs:ignore
/**
 * Images
 *
 * @package WordPress
 * @subpackage UNI
 */

namespace UNI\Plugins\ACF\Fields;

/**
 * Images
 */
class Images {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'acf/init', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields() {
		$location = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'product',
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_5ea74ea87de55',
					'title'    => __( 'Images Fields', 'uni' ),
					'fields'   => array(
						array(
							'key'           => 'field_5eb24d1ca8cbc',
							'label'         => __( 'Overview', 'uni' ),
							'name'          => 'image_hover',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
						),
					),
					'location' => $location,
					// 'position'   => 'normal',
					// 'style'      => 'default',
				)
			);
		}
	}
}
