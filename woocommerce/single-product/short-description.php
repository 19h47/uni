<?php
/**
 * Single product short description
 *
 * @package UNI
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Timber\{ Timber };

global $post;

$context = Timber::context();

$context['short_description'] = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

Timber::render( 'woocommerce/single-product/short-description.html.twig', $context );
