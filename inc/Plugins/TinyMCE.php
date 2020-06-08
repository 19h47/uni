<?php // phpcs:ignore
/**
 * TinyMCE
 *
 * @package UNI
 */

namespace UNI\Plugins;

/**
 * TinyMCE
 */
class TinyMCE {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'tiny_mce_before_init', array( $this, 'forced_root_block' ), 10, 2 );
	}

	/**
	 * Line breaks
	 *
	 * @param array  $mceInit An array with TinyMCE config.
	 * @param string $editor_id Unique editor identifier, e.g. 'content'. Accepts 'classic-block' when called from block editor's Classic block.
	 */
	function forced_root_block( array $mceInit, string $editor_id ) { // phpcs:ignore
		$mceInit['forced_root_block'] = 'br';

		return $mceInit; // phpcs:ignore
	}
}


