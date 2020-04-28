<?php
/**
 * Product Loop Start
 *
 * @package UNI
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['columns'] = wc_get_loop_prop( 'columns' );

Timber::render( 'woocommerce/loop/loop-start.html.twig', $context );
