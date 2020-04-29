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

$context['show_page_title'] = apply_filters( 'woocommerce_show_page_title', true );
$context['page_title']      = woocommerce_page_title( false );
$context['product_loop']    = woocommerce_product_loop();

$context['post'] = Timber::get_post( get_option( 'woocommerce_shop_page_id' ) );

if ( is_product_category() ) {
	$context['post'] = Timber::get_term( get_queried_object()->term_id, 'product_cat' );
}

$context['post']->body_classes = array( 'Archive-product' );
$context['post']->node_type    = 'HorizontalPage';

Timber::render( 'pages/archive-product.html.twig', $context );
