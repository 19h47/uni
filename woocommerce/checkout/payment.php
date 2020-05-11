<?php
/**
 * Checkout Payment Section
 *
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package UNI/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['is_ajax'] = is_ajax();
$context['cart']    = WC()->cart;

$context['available_gateways'] = $available_gateways;
$context['order_button_text']  = $order_button_text;

$context['billing_country'] = WC()->customer->get_billing_country();

$context['nonce_field'] = wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' );

Timber::render( 'woocommerce/checkout/payment.html.twig', $context );
