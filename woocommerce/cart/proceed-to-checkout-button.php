<?php
/**
 * Proceed to checkout button
 *
 * @package UNI/Templates
 * @version 7.0.1
 */

use Timber\{ Timber };

$context = Timber::context();

Timber::render( 'woocommerce/cart/proceed-to-checkout.html.twig', $context );
