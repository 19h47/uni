<?php
/**
 * Shipping Calculator
 *
 * @package UNI/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['cart_url']    = wc_get_cart_url();
$context['nonce_field'] = wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce', true, false );
$context['button_text'] = $button_text;

$context['countries'] = WC()->countries->get_shipping_countries();

// Shipping.
$context['shipping'] = array(
	'state'    => WC()->customer->get_shipping_state(),
	'country'  => WC()->customer->get_shipping_country(),
	'city'     => WC()->customer->get_shipping_city(),
	'postcode' => WC()->customer->get_shipping_postcode(),
);

$context['states'] = WC()->countries->get_states( $context['shipping']['country'] );


Timber::render( 'woocommerce/cart/shipping-calculator.html.twig' );
