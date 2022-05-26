<?php
/**
 * Checkout billing information form
 *
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['checkout'] = $checkout;
$context['cart']     = WC()->cart;

$context['ship_to_billing_address_only'] = (bool) wc_ship_to_billing_address_only();

Timber::render( 'woocommerce/checkout/form-billing.html.twig', $context );
