<?php
/**
 * Checkout Form
 *
 * @package UNI
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new Post();

$context['checkout_url']    = wc_get_checkout_url();
$context['checkout_fields'] = $checkout->get_checkout_fields();
$context['checkout']        = $checkout;

Timber::render( 'woocommerce/checkout/form-checkout.html.twig', $context );
