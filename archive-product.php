<?php
/**
 * Archive: product
 *
 * @package uniUNI
 */

global $product;

use Timber\{ Timber };

$context = Timber::get_context();

$context['products'] = Timber::get_posts();

if ( is_product_category() ) {
	$term_id             = get_queried_object()->term_id;
	$context['category'] = get_term( $term_id, 'product_cat' );
	$context['title']    = single_term_title( '', false );
} else {
	$context['post']    = Timber::get_post( get_option( 'woocommerce_shop_page_id' ) );
	$context['title']   = $context['post']->title;
	$context['content'] = $context['post']->content;
}

Timber::render( 'woo/archive.html.twig', $context );
