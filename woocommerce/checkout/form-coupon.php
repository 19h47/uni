<?php
/**
 * Checkout: Coupon Form
 *
 * @package UNI/Templates
 * @version 3.4.4
 */

use Timber\{ Timber };

$context = Timber::context();

$context['coupons_enabled'] = wc_coupons_enabled();
$context['classes']         = array( 'mb-12px' );

Timber::render( 'woocommerce/checkout/form-coupon.html.twig', $context );
