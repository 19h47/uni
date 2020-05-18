<?php
/**
 * Checkout coupon form
 *
 * @package UNI/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['coupons_enabled'] = wc_coupons_enabled();

Timber::render( 'woocommerce/checkout/form-coupon.html.twig', $context );
