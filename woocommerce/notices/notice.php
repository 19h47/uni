<?php
/**
 * Show messages
 *
 * @package UNI/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['notices'] = $notices;

Timber::render( 'woocommerce/notices/notice.html.twig', $context );
