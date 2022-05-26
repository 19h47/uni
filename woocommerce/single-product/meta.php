<?php
/**
 * Single Product Meta
 *
 * @package     UNI
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Timber\{ Timber };

global $product;

$context = Timber::get_context();

$sku = $product->get_sku();

if ( wc_product_sku_enabled() && ( $sku || $product->is_type( 'variable' ) ) ) {
	$context['sku'] = $sku;
}

$context['product_category_list'] = wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'uni' ) . ' ', '</span>' );
$context['product_tag_list']      = wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' );


Timber::render( 'woocommerce/single-product/meta.html.twig', $context );
