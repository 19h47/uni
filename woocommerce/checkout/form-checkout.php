<?php
/**
 * Checkout Form
 *
 * @param WC_Checkout $checkout Checkout object.
 *
 * @package UNI
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['checkout']          = (object) $checkout;
$context['checkout_url']      = wc_get_checkout_url();
$context['is_user_logged_in'] = is_user_logged_in();

Timber::render( 'woocommerce/checkout/form-checkout.html.twig', $context );
