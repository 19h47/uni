<?php
/**
 * Proceed to checkout button
 *
 * @package UNI/Templates
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['checkout_url'] = wc_get_checkout_url();

Timber::render( 'woocommerce/cart/proceed-to-checkout.html.twig', $context );
