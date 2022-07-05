<?php
/**
 * Cart totals
 *
 * @package UNI/Templates
 * @version 2.3.6
 */

use Timber\{ Timber, Helper };

$context = Timber::context();

$context['html'] = array(
	'subtotal'    => Helper::ob_function( 'wc_cart_totals_subtotal_html' ),
	'shipping'    => Helper::ob_function( 'wc_cart_totals_shipping_html' ),
	'order_total' => Helper::ob_function( 'wc_cart_totals_order_total_html' ),
	'taxes_total' => Helper::ob_function( 'wc_cart_totals_taxes_total_html' ),
);

$context['enable_shipping_calc'] = get_option( 'woocommerce_enable_shipping_calc' );
$context['tax_total_display']    = get_option( 'woocommerce_tax_total_display' );

$context['shipping_calculator'] = Helper::ob_function( 'woocommerce_shipping_calculator', __( 'Validate', 'uni' ) );

$context['tax_enabled'] = wc_tax_enabled();


Timber::render( 'woocommerce/cart/cart-totals.html.twig', $context );
