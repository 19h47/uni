<?php
/**
 * Cart: Empty
 *
 * @package UNI
 * @version 3.5.0
 */

use Timber\{ Timber, Post };

$context = Timber::context();

$context['page'] = array(
	'id'        => wc_get_page_id( 'shop' ),
	'permalink' => apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ),
);

Timber::render( 'woocommerce/cart/cart-empty.html.twig', $context );
