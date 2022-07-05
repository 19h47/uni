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

$data = Timber::get_context();

$data['products'] = Transients::products();

$data['show_page_title'] = apply_filters( 'woocommerce_show_page_title', true );
$data['page_title']      = woocommerce_page_title( false );
$data['product_loop']    = woocommerce_product_loop();

$data['post'] = Timber::get_post( get_option( 'woocommerce_shop_page_id' ) );

if ( is_product_category() ) {
	$data['post'] = Timber::get_term( get_queried_object()->term_id, 'product_cat' );
}

$data['post']->body_classes = array( 'Archive-page' );
$data['post']->modules      = array( 'horizontal-page' );

Timber::render( 'pages/archive-product.html.twig', $data );
