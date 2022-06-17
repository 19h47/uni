<?php // phpcs:ignore
/**
 * Project
 *
 * @package WordPress
 * @subpackage UNI
 */

namespace UNI\Plugins\ACF\Fields;

/**
 * Project
 */
class Project {

	/**
	 * Key
	 *
	 * @var string
	 */
	private $key = 'project';

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
					'value'    => 'project',
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_5ed8b39eb5eaa',
					'title'    => __( 'Project Fields', 'uni' ),
					'fields'   => array(
						array(
							'key'           => 'field_' . $this->key . '_color',
							'name'          => 'color',
							'label'         => __( 'Color', 'uni' ),
							'type'          => 'color_picker',
							'return_format' => 'string',
						),
						array(
							'key'          => 'field_5ed8b3a484292',
							'label'        => __( 'Attributes', 'uni' ),
							'name'         => 'project_attributes',
							'type'         => 'repeater',
							'layout'       => 'table',
							'button_label' => __( 'Add Attribute', 'uni' ),
							'sub_fields'   => array(
								array(
									'key'        => 'field_5ed8b3e084293',
									'label'      => __( 'Attribute', 'uni' ),
									'name'       => 'attribute',
									'type'       => 'group',
									'layout'     => 'block',
									'sub_fields' => array(
										array(
											'key'   => 'field_5ed8b3fe84294',
											'label' => __( 'Name', 'uni' ),
											'name'  => 'name',
											'type'  => 'text',
										),
										array(
											'key'   => 'field_5ed8b40884295',
											'label' => __( 'Value', 'uni' ),
											'name'  => 'value',
											'type'  => 'text',
										),
									),
								),
							),
						),
						array(
							'key'          => 'field_5ed8c285eb84b',
							'label'        => __( 'Content', 'uni' ),
							'name'         => 'project_content',
							'type'         => 'wysiwyg',
							'tabs'         => 'all',
							'toolbar'      => 'full',
							'media_upload' => 1,
							'delay'        => 0,
						),
						array(
							'key'           => 'field_5ed8d070040e8',
							'label'         => __( 'Images', 'uni' ),
							'name'          => 'images',
							'type'          => 'gallery',
							'return_format' => 'array',
							'preview_size'  => 'medium',
							'insert'        => 'append',
							'library'       => 'all',
						),
					),
					'location' => $location,
				)
			);

		}
	}
}
