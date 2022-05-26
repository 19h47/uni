<?php
/**
 * Product Loop End
 *
 * @package     UNI
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Timber\{ Timber };

Timber::render( 'woocommerce/loop/loop-end.html.twig' );
