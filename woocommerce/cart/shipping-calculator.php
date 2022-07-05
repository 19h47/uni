<?php
/**
 * Shipping Calculator
 *
 * @package UNI/Templates
 * @version 4.0.0
 */

use Timber\{ Timber };

$context = Timber::context();

$context['nonce_field'] = wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce', true, false );
$context['button_text'] = $button_text;

// Shipping.
$context['shipping'] = array(
	'state'    => $context['customer']->get_shipping_state(),
	'country'  => $context['customer']->get_shipping_country(),
	'city'     => $context['customer']->get_shipping_city(),
	'postcode' => $context['customer']->get_shipping_postcode(),
);

$context['states']    = $context['countries']->get_states( $context['shipping']['country'] );
$context['countries'] = $context['countries']->get_shipping_countries();

Timber::render( 'woocommerce/cart/shipping-calculator.html.twig', $context );
