<?php
/**
 * Output a single payment method
 *
 * @package     WooCommerce/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['gateway'] = $gateway;

Timber::render( 'woocommerce/checkout/payment-method.html.twig', $context );
