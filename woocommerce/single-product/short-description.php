<?php
/**
 * Single product short description
 *
 * @package UNI
 */

use Timber\{ Timber };

global $post;

$context = Timber::get_context();

$context['short_description'] = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

Timber::render( 'woocommerce/single-product/short-description.html.twig', $context );
