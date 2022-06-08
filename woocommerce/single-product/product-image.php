<?php
/**
 * Single Product Image
 *
 * @package uni
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

use Timber\{ Timber };

$context = Timber::get_context();

$context['columns'] = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );

$context['post_thumbnail_id'] = $product->get_image_id();

$wrapper_classes = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'Product-gallery',
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $context['post_thumbnail_id'] ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $context['columns'] ),
		'images',
	)
);

$context['wrapper_class'] = esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) );

$context['image_ids'] = $product->get_gallery_image_ids();


Timber::render( 'woocommerce/single-product/product-gallery.html.twig', $context );
