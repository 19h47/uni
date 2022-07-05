<?php
/**
 * Show error messages
 *
 * @package UNI/Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Timber\{ Timber };

$context = Timber::context();

$context['notices'] = $notices;

Timber::render( 'woocommerce/notices/error.html.twig', $context );
