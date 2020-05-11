<?php
/**
 * Checkout Form
 *
 * @param WC_Checkout $checkout Checkout object.
 *
 * @package UNI
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['checkout']     = (object) $checkout;
$context['checkout_url'] = wc_get_checkout_url();

Timber::render( 'woocommerce/checkout/form-checkout.html.twig', $context );
