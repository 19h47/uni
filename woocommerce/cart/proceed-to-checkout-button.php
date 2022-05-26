<?php
/**
 * Proceed to checkout button
 *
 * @package UNI/Templates
 * @version 2.4.0
 */

use Timber\{ Timber };

$context = Timber::get_context();

Timber::render( 'woocommerce/cart/proceed-to-checkout.html.twig', $context );
