<?php
/**
 * Cart totals
 *
 * @package UNI/Templates
 */

use Timber\{ Timber, Helper };

$context = Timber::get_context();

$context['has_calculated_shipping'] = WC()->customer->has_calculated_shipping();


$context['cart_totals_subtotal_html'] = Helper::ob_function( 'wc_cart_totals_subtotal_html' );

$context['coupons'] = WC()->cart->get_coupons();

$context['needs_shipping'] = WC()->cart->needs_shipping();
$context['show_shipping']  = WC()->cart->show_shipping();

$context['cart_totals_shipping_html'] = Helper::ob_function( 'wc_cart_totals_shipping_html' );

$context['enable_shipping_calc'] = get_option( 'woocommerce_enable_shipping_calc' );

$context['woocommerce_shipping_calculator'] = Helper::ob_function( 'woocommerce_shipping_calculator', __( 'Validate', 'uni' ) );

$context['fees'] = WC()->cart->get_fees();

if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
	$taxable_address = WC()->customer->get_taxable_address();
	$context['estimated_text'] = '';

	if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
		/* translators: %s location. */
		$context['estimated_text'] = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
	}

	$context['tax_total_display'] = get_option( 'woocommerce_tax_total_display' );
	$context['tax_totals']        = WC()->cart->get_tax_totals();
	$context['tax_or_vat']        = WC()->countries->tax_or_vat();

	$context['cart_totals_taxes_total_html'] = Helper::ob_function( 'wc_cart_totals_taxes_total_html' );
}

$context['cart_totals_order_total_html'] = Helper::ob_function( 'wc_cart_totals_order_total_html' );


Timber::render( 'woocommerce/cart/cart-totals.html.twig', $context );







