<?php
/**
 * Cart: empty
 *
 * @package UNI
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['page_id'] = wc_get_page_id( 'shop' );
$context['url']     = apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) );


Timber::render( 'woo/cart/cart-empty.html.twig', $context );
