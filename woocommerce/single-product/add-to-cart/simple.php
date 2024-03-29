<?php
/**
 * Simple product add to cart
 *
 * @package UNI/Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

use Timber\{ Timber };

global $product;

$context = Timber::context();

$context['id']             = $product->get_id();
$context['stock_html']     = wc_get_stock_html( $product );
$context['is_in_stock']    = $product->is_in_stock();
$context['upcoming']       = get_post_meta( $product->get_id(), '_upcoming', true );
$context['form_action']    = apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() );
$context['text']           = $product->single_add_to_cart_text();
$context['quantity_input'] = woocommerce_quantity_input(
	array(
		'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
		'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
	),
	$product,
	false
);



Timber::render( 'woocommerce/single-product/add-to-cart/simple.html.twig', $context );
