<?php // phpcs:ignore
/**
 * Project post
 *
 * PHP version 7.3.8
 *
 * @package uni
 */

namespace UNI\Models;

use Timber\{ Timber, Post };

/**
 * Product post
 */
class ProjectPost extends Post {

	/**
	 * Modules
	 *
	 * @var array $modules
	 */
	public $modules = array( 'horizontal-page' );


	/**
	 * Attributes
	 *
	 * @return array
	 */
	public function attributes() : array {
		$attributes         = array();
		$project_attributes = get_field( 'project_attributes', $this->id );

		if ( ! $project_attributes ) {
			return $attributes;
		}

		foreach ( $project_attributes as $item ) {
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

	/**
	 * Images
	 *
	 * @return array
	 */
	public function images() : array {
		$images = get_field( 'images', $this->ID );

		if ( $images ) {
			$count = count( $images );

			for ( $i = 0; $i < $count; $i++ ) {
				$rows = get_field( 'rows', $images[ $i ]['id'] );

				if ( $rows ) {
					$padding = ( ( ( ( 116.36 * ( 11 - $rows ) ) * 100 ) / 1440 ) / 2 ) . 'vh';

					$images[ $i ]['id']    = $images[ $i ]['name'];
					$images[ $i ]['style'] = '<style>@media (min-width: 992px) { #' . $images[ $i ]['name'] . "{ padding-top: $padding; padding-bottom: $padding; } }</style>";
				}
			}

			return $images;
		}

		return array();
	}


	/**
	 * First project
	 *
	 * @return object
	 */
	public function first_project() : object {
		return Timber::get_posts(
			array(
				'post_type'      => 'project',
				'posts_per_page' => 1,
				'order'          => 'DESC',
				'no_found_rows'  => true,
			),
		)[0];
	}


	/**
	 * Updcoming
	 */
	public function upcoming() : boolean {
		return get_post_meta( $this->id, '_upcoming', true );
	}
}
