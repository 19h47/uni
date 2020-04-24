<?php
/**
 * Checkout Form
 *
 * @package UNI
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post']     = new Post();
$context['action']   = wc_get_checkout_url();
$context['checkout'] = $checkout;

if ( $checkout->get_checkout_fields() ) {
	$context['show_fields'] = true;
}

Timber::render( 'woo/checkout/form-checkout.html.twig', $context );
