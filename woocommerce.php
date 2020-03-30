<?php
/**
 * WooCommerce
 *
 * @package WordPress
 * @subpackage UNI
 */

use Timber\{ Timber };
use UNI\{ Transients };

$context = Timber::get_context();

// $context['cart'] = WC()->cart->get_cart_contents_count();


if ( is_singular( 'product' ) ) {

	$context['post']    = Timber::get_post();
	$product            = wc_get_product( $context['post']->ID );
	$context['product'] = $product;

	$related_limit               = wc_get_loop_prop( 'columns' );
	$related_ids                 = wc_get_related_products( $context['post']->id, $related_limit );
	$context['related_products'] = Timber::get_posts( $related_ids );

	// Restore the context and loop back to the main query loop.
	wp_reset_postdata();

	Timber::render( 'woo/single-product.html.twig', $context );
} else {
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
}
