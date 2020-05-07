<?php
/**
 * Checkout Form
 *
 * @param WC_Checkout $checkout
 *
 * @package UNI
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['checkout_url'] = wc_get_checkout_url();
$context['checkout']     = $checkout;

Timber::render( 'woocommerce/checkout/form-checkout.html.twig', $context );
