<?php // phpcs:ignore
/**
 * Archive Page
 *
 * PHP version 7.3.8
 *
 * @package uni
 */

namespace UNI\Models;

use Timber\{ Timber, Post };
use UNI\Models\{ ProjectPost };

/**
 * Archive Page
 */
class ArchivePage extends Post {
	/**
	 * Body Classes
	 *
	 * @var array $modules
	 */
	public $body_classes = array( 'Archive-page' );

	/**
	 * Modules
	 *
	 * @var array $modules
	 */
	public $modules = array( 'horizontal-page' );

	public function items() : array {
		$items = get_field( 'gallery', $this->ID );
		$array = array();

		foreach ( $items as $key => $item ) {
			$array[ $key ] = array(
				'image'       => $item['image'],
				'image_hover' => $item['image_hover'],
				'mobile'      => $item['mobile'],
				'link'        => $item['link'],
			);

			if ( $item['project'][0] ) {
				$array[ $key ]['project'] = Timber::get_post( $item['project'][0] );
			}
		}

		return $array;
	}
}
