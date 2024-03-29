<?php
/**
 * Variable product add to cart
 *
 * @package UNI/Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

use TImber\{ Timber };

$context = Timber::context();

$variations_json            = wp_json_encode( $available_variations );
$context['variations_attr'] = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

$context['product']              = $product;
$context['attributes']           = $attributes;
$context['attribute_keys']       = array_keys( $attributes );
$context['available_variations'] = $available_variations;
$context['form_action']          = apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() );

Timber::render( 'woocommerce/single-product/add-to-cart/variable.html.twig', $context );
