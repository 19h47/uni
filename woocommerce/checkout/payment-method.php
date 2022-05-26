<?php
/**
 * Output a single payment method
 *
 * @param object $gateway Object gateway.
 *
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['gateway'] = (object) $gateway;

Timber::render( 'woocommerce/checkout/payment-method.html.twig', $context );
