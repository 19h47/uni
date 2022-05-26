<?php
/**
 * Checkout Payment Section
 *
 * @param WC_Checkout $checkout WC_Checkout object.
 * @param array $available_gateways Array of WC_Gateway_BACS gateways.
 * @param string $order_button_text Order button text.
 *
 * @see     https://github.com/woocommerce/woocommerce/blob/master/includes/wc-template-functions.php#L2227
 * @package UNI/Templates
 * @version 3.5.3
 */

use Timber\{ Timber };

$context = Timber::get_context();

// @see https://github.com/woocommerce/woocommerce/blob/master/includes/wc-template-functions.php#L2240
$context['checkout']           = (object) $checkout;
$context['available_gateways'] = (array) $available_gateways;
$context['order_button_text']  = (string) $order_button_text;

$context['nonce_field'] = wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' );

Timber::render( 'woocommerce/checkout/payment.html.twig', $context );
