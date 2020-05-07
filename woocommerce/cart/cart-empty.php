<?php
/**
 * Cart: empty
 *
 * @package UNI
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['page_id']        = wc_get_page_id( 'shop' );
$context['page_permalink'] = wc_get_page_permalink( 'shop' );

Timber::render( 'woocommerce/cart/cart-empty.html.twig', $context );
