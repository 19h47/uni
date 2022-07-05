<?php
/**
 * Checkout shipping information form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

use Timber\{ Timber };

$context = Timber::context();

$context['checkout'] = $checkout;
$context['cart']     = WC()->cart;

$context['ship_to_destination']   = get_option( 'woocommerce_ship_to_destination' );
$context['enable_order_comments'] = get_option( 'woocommerce_enable_order_comments', 'yes' );

$context['ship_to_billing_address_only'] = wc_ship_to_billing_address_only();

Timber::render( 'woocommerce/checkout/form-shipping.html.twig', $context );
