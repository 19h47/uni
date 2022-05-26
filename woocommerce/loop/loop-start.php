<?php
/**
 * Product Loop Start
 *
 * @package UNI
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Timber\{ Timber };

$context = Timber::get_context();

$context['columns'] = wc_get_loop_prop( 'columns' );

Timber::render( 'woocommerce/loop/loop-start.html.twig', $context );
