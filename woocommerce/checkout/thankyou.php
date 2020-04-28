<?php
/**
 * Thank you page
 *
 * @package uni
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new TimberPost();

$context['order']              = $order;
$context['order_date_created'] = wc_format_datetime( $order->get_date_created() );

$context['is_user_logged_in']   = is_user_logged_in();
$context['current_user_id']     = get_current_user_id();
$context['myaccount_permalink'] = wc_get_page_permalink( 'myaccount' );

$context['thankyou_order_received_test'] = apply_filters( 'woocommerce_thankyou_order_received_text', pll__( 'Thank you. Your order has been received.' ), $order );

Timber::render( 'woocommerce/checkout/thankyou.html.twig', $context );
