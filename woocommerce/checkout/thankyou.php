<?php
/**
 * Thank you page
 *
 * @param WC_Order $order Order object.
 *
 * @package uni
 */

use Timber\{ Timber };

$context = Timber::get_context();

$context['order']              = $order; // $order;
$context['order_date_created'] = $order ? wc_format_datetime( $order->get_date_created() ) : false;

$context['is_user_logged_in']   = is_user_logged_in();
$context['current_user_id']     = get_current_user_id();
$context['myaccount_permalink'] = wc_get_page_permalink( 'myaccount' );

Timber::render( 'woocommerce/checkout/thankyou.html.twig', $context );
