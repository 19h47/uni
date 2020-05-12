<?php
/**
 * Review order table
 *
 * @package UNI/Templates
 */

use Timber\{ Timber, Helper };

$context = Timber::get_context();

$context['cart']      = WC()->cart;
$context['countries'] = WC()->countries;

$context['tax_enabled']       = wc_tax_enabled();
$context['tax_total_display'] = get_option( 'woocommerce_tax_total_display' );

$context['html'] = array(
	'order_total' => Helper::ob_function( 'wc_cart_totals_order_total_html' ),
	'taxes_total' => Helper::ob_function( 'wc_cart_totals_taxes_total_html' ),
	'shipping'    => Helper::ob_function( 'wc_cart_totals_shipping_html' ),
	'subtotal'    => Helper::ob_function( 'wc_cart_totals_subtotal_html' ),
);


Timber::render( 'woocommerce/checkout/review-order.html.twig', $context );
