<?php
/**
 * Checkout Form
 *
 * @param WC_Checkout $checkout Checkout object.
 *
 * @package UNI
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Timber\{ Timber };

$context = Timber::get_context();

$context['checkout'] = (object) $checkout;

Timber::render( 'woocommerce/checkout/form-checkout.html.twig', $context );
