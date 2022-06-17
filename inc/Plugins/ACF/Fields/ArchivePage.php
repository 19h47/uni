<?php // phpcs:ignore
/**
 * Archive Page
 *
 * @package WordPress
 * @subpackage UNI
 */

namespace UNI\Plugins\ACF\Fields;

/**
 * Archive Page
 */
class ArchivePage {
	/**
	 * Key
	 *
	 * @var string
	 */
	private $key = 'archive_page';

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
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'templates/archive-page.php',
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'                   => 'group_5ebba135dd8e8',
					'title'                 => __( 'Archive Fields', 'uni' ),
					'fields'                => array(
						array(
							'key'   => 'field_5ebba20b21b77',
							'label' => __( 'Subtitle', 'uni' ),
							'name'  => 'subtitle',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_5ebba3e51e358',
							'label'        => __( 'Gallery', 'uni' ),
							'name'         => 'gallery',
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Image', 'uni' ),
							'sub_fields'   => array(
								array(
									'key'           => 'field_5ebba41e1e359',
									'label'         => __( 'Image', 'uni' ),
									'name'          => 'image',
									'type'          => 'image',
									'return_format' => 'id',
									'preview_size'  => 'medium',
									'library'       => 'all',
									'wrapper'       => array( 'width' => 25 ),
								),
								array(
									'key'           => 'field_5ebba4661e35a',
									'label'         => __( 'Overview', 'uni' ),
									'name'          => 'image_hover',
									'type'          => 'image',
									'return_format' => 'id',
									'preview_size'  => 'medium',
									'library'       => 'all',
									'wrapper'       => array( 'width' => 25 ),
								),
								array(
									'key'        => 'field_' . $this->key . '_mobile',
									'label'      => __( 'Mobile', 'uni' ),
									'name'       => 'mobile',
									'type'       => 'group',
									'wrapper'    => array( 'width' => 50 ),
									'sub_fields' => array(
										array(
											'key'          => 'field_' . $this->key . '_mobile_image',
											'label'        => __( 'Image', 'uni' ),
											'name'         => 'image',
											'type'         => 'image',
											'return_format' => 'id',
											'preview_size' => 'medium',
											'library'      => 'all',
										),
										array(
											'key'          => 'field_' . $this->key . '_mobile_overview',
											'label'        => __( 'Overview', 'uni' ),
											'name'         => 'overview',
											'type'         => 'image',
											'return_format' => 'id',
											'preview_size' => 'medium',
											'library'      => 'all',
										),
									),
								),
								array(
									'key'           => 'field_5eda869f739de',
									'label'         => __( 'Project', 'uni' ),
									'name'          => 'project',
									'type'          => 'post_object',
									'post_type'     => array( 'project' ),
									'taxonomy'      => '',
									'allow_null'    => 0,
									'multiple'      => 1,
									'return_format' => 'id',
									'ui'            => 1,
								),
							),
						),
						array(
							'key'           => 'field_5ebba8dbf8f98',
							'label'         => __( 'Link', 'uni' ),
							'name'          => 'link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
					'location'              => $location,
					'menu_order'            => 0,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'description'           => __( 'Archive Page Fields', 'uni' ),
					'show_in_rest'          => 0,
				)
			);
		}
	}
}
