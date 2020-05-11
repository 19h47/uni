<?php
/**
 * Cart totals
 *
 * @package UNI/Templates
 */

use Timber\{ Timber, Helper };

$context = Timber::get_context();

$context['cart']     = WC()->cart;
$context['customer'] = WC()->customer;

$context['html'] = array(
	'subtotal'    => Helper::ob_function( 'wc_cart_totals_subtotal_html' ),
	'shipping'    => Helper::ob_function( 'wc_cart_totals_shipping_html' ),
	'order_total' => Helper::ob_function( 'wc_cart_totals_order_total_html' ),
	'taxes_total' => Helper::ob_function( 'wc_cart_totals_taxes_total_html' ),
);

$context['enable_shipping_calc'] = get_option( 'woocommerce_enable_shipping_calc' );

$context['shipping_calculator'] = Helper::ob_function( 'woocommerce_shipping_calculator', __( 'Validate', 'uni' ) );

if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
	$taxable_address           = WC()->customer->get_taxable_address();
	$context['estimated_text'] = '';

	if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
		/* translators: %s location. */
		$context['estimated_text'] = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
	}

	$context['tax_total_display'] = get_option( 'woocommerce_tax_total_display' );
	$context['tax_or_vat']        = WC()->countries->tax_or_vat();
}


Timber::render( 'woocommerce/cart/cart-totals.html.twig', $context );







