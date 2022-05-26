<?php
/**
 * Archive: Product
 *
 * @package UNI
 * @subpackage WordPress
 * @version 3.4.0
 */

global $product;

use Timber\{ Timber };
use UNI\Core\{ Transients };

$context = Timber::get_context();

$context['products'] = Transients::products();

$context['show_page_title'] = apply_filters( 'woocommerce_show_page_title', true );
$context['page_title']      = woocommerce_page_title( false );
$context['product_loop']    = woocommerce_product_loop();

$context['post'] = Timber::get_post( get_option( 'woocommerce_shop_page_id' ) );

if ( is_product_category() ) {
	$context['post'] = Timber::get_term( get_queried_object()->term_id, 'product_cat' );
}

$context['post']->body_classes = array( 'Archive-page' );
$context['post']->node_type    = 'HorizontalPage';

Timber::render( 'pages/archive-product.html.twig', $context );
