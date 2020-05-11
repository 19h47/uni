<?php
/**
 * Output a single payment method
 *
 * @param object $gateway Object gateway.
 *
 * @package     WooCommerce/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['gateway'] = (object) $gateway;

Timber::render( 'woocommerce/checkout/payment-method.html.twig', $context );
