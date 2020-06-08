<?php // phpcs:ignore
/**
 * Project post
 *
 * PHP version 7.3.8
 *
 * @package uni
 */

namespace UNI\Models;

use Timber\{ Post };

/**
 * Product post
 */
class ProjectPost extends Post {

	/**
	 * Node type
	 *
	 * @var string $node_type
	 */
	public $node_type = 'HorizontalPage';


	/**
	 * Attributes
	 *
	 * @return array
	 */
	public function attributes() : array {
		$attributes = array();

		foreach ( get_field( 'project_attributes', $this->id ) as $item ) {
			$attribute = $item['attribute'];

			array_push(
				$attributes,
				array(
					'name'    => $attribute['name'],
					'options' => array( $attribute['value'] ),
				)
			);

		}

		return $attributes;
	}
}
