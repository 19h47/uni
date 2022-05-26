<?php
/**
 * Thank you page
 *
 * @param WC_Order $order Order object.
 *
 * @package uni
 * @version 3.7.0
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['order']              = $order; // $order;
$context['order_date_created'] = $order ? wc_format_datetime( $order->get_date_created() ) : false;

Timber::render( 'woocommerce/checkout/thankyou.html.twig', $context );
