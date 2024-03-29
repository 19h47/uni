<?php
/**
 * Single Product Price
 *
 * @package uni
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Timber\{ Timber };

global $product;

$context = Timber::context();

$context['price_html'] = $product->get_price_html();
$context['upcoming']   = get_post_meta( $product->get_id(), '_upcoming', true );

Timber::render( 'woocommerce/single-product/price.html.twig', $context );
