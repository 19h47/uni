<?php
/**
 * Shipping Calculator
 *
 * @package UNI/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['cart_url'] = wc_get_cart_url();

$context['button_text'] = $button_text;

// States.
$shipping_country  = WC()->customer->get_shipping_country();
$context['states'] = WC()->countries->get_states( $shipping_country );

// Shipping.
$context['shipping'] = array(
	'state'     => WC()->customer->get_shipping_state(),
	'countries' => WC()->countries->get_shipping_countries(),
	'city'      => WC()->customer->get_shipping_city(),
	'postcode'  => WC()->customer->get_shipping_postcode(),
);

$context['nonce_field'] = wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce', true, false )

Timber::render( 'woocommerce/cart/shipping-calculator.html.twig' );
