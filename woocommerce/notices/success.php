<?php
/**
 * Show messages
 *
 * @package UNI/Templates
 */

use Timber\{ Timber };

$context['notices'] = $notices;

Timber::render( 'woocommerce/notices/success.html.twig', $context );
