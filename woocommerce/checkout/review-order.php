<?php
/**
 * Checkout: Review Order
 *
 * @package UNI/Templates
 * @version 5.2.0
 */

use Timber\{ Timber, Helper };

$context = Timber::context();

$context['tax_enabled']       = wc_tax_enabled();
$context['tax_total_display'] = get_option( 'woocommerce_tax_total_display' );

$context['html'] = array(
	'order_total' => Helper::ob_function( 'wc_cart_totals_order_total_html' ),
	'taxes_total' => Helper::ob_function( 'wc_cart_totals_taxes_total_html' ),
	'shipping'    => Helper::ob_function( 'wc_cart_totals_shipping_html' ),
	'subtotal'    => Helper::ob_function( 'wc_cart_totals_subtotal_html' ),
);

Timber::render( 'woocommerce/checkout/review-order.html.twig', $context );
