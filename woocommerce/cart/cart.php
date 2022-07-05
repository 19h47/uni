<?php
/**
 * Cart Page
 *
 * @package UNI
 * @version 3.8.0
 */

use Timber\{ Timber, Post };

$context = Timber::context();

$context['coupons_enabled'] = wc_coupons_enabled();
$context['nonce_field']     = wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce', true, false );
$context['products']        = array();

foreach ( WC()->cart->get_cart() as $key => $value ) {
	$products_array = array();

	// General vars.
	$_product   = apply_filters( 'woocommerce_cart_item_product', $value['data'], $value, $key );
	$product_id = apply_filters( 'woocommerce_cart_item_product_id', $value['product_id'], $value, $key );

	if ( $_product && $_product->exists() && $value['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $value, $key ) ) {

		$products_array['item_class'] = apply_filters( 'woocommerce_cart_item_class', 'cart_item', $value, $key );

		// URL.
		$product_permalink     = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $value ) : '', $value, $key );
		$products_array['url'] = get_permalink( $product_id );

		// Remove.
		// $products_array['remove'] = apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		// 'woocommerce_cart_item_remove_link',
		// sprintf(
		// '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
		// esc_url( wc_get_cart_remove_url( $key ) ),
		// esc_html__( 'Remove this item', 'woocommerce' ),
		// esc_attr( $product_id ),
		// esc_attr( $_product->get_sku() )
		// ),
		// $key
		// );

		// Thumbnail.
		$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $value, $key );

		$products_array['image_id'] = $_product->get_image_id();

		// $products_array['thumbnail'] = sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );

		// if ( ! $product_permalink ) {
		// $products_array['thumbnail'] = $thumbnail;
		// }

		// Name.
		$products_array['name'] = wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $value, $key ) );

		if ( ! $product_permalink ) {
			$products_array['name'] = wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $value, $key ) . '&nbsp;' );
		}

		do_action( 'woocommerce_after_cart_item_name', $value, $key );

		// Meta data.
		$products_array['formatted_cart_item_data'] = wc_get_formatted_cart_item_data( $value );

		// Backorder notification.
		if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $value['quantity'] ) ) {
			$products_array['backorder'] = apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id );
		}

		// Price.
		$products_array['price'] = apply_filters(
			'woocommerce_cart_item_price',
			WC()->cart->get_product_price( $_product ),
			$value,
			$key
		);

		// Quantity.
		$product_quantity = woocommerce_quantity_input(
			array(
				'input_name'   => "cart[{$key}][qty]",
				'input_value'  => $value['quantity'],
				'max_value'    => $_product->get_max_purchase_quantity(),
				'min_value'    => '0',
				'product_name' => $_product->get_name(),
			),
			$_product,
			false
		);

		if ( $_product->is_sold_individually() ) {
			$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1">', $key );
		}

		$products_array['quantity'] = apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $key, $value );

		// Subtotal.
		$products_array['subtotal'] = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $value['quantity'] ), $value, $key );

		// Merge with products.
		$context['products'][] = $products_array;
	}
}

Timber::render( 'woocommerce/cart/cart.html.twig', $context );
