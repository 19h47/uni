<?php
/**
 * Show messages
 *
 * @package UNI/Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Timber\{ Timber };

$context = Timber::context();

$context['notices'] = $notices;

Timber::render( 'woocommerce/notices/notice.html.twig', $context );
