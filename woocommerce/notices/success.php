<?php
/**
 * Show messages
 *
 * @package UNI/Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Timber\{ Timber };

$context['notices'] = $notices;

Timber::render( 'woocommerce/notices/success.html.twig', $context );
