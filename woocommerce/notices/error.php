<?php
/**
 * Show error messages
 *
 * @package UNI/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['notices'] = $notices;

Timber::render( 'woocommerce/notices/error.html.twig', $context );
