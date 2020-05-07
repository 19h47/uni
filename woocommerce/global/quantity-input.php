<?php
/**
 * Product quantity inputs
 *
 * @param int $input_id
 * @param string $input_name
 * @param string $input_value
 * @param array $classes
 * @param int $max_value
 * @param int $min_value
 * @param int $step
 * @param string $pattern
 * @param string $inputmode
 * @param string $product_name
 * @param string $placeholder
 *
 * @package UNI/Templates
 */

$context = Timber::get_context();

$context['input'] = array(
	'id'          => $input_id,
	'name'        => $input_name,
	'value'       => $input_value,
	'classes'     => $classes,
	'max_value'   => $max_value,
	'min_value'   => $min_value,
	'step'        => $step,
	'patern'      => $pattern,
	'inputmode'   => $inputmode,
	'placeholder' => $placeholder,
	'size'        => 4,
);

$context['product_name'] = $product_name;

/* translators: %s: Quantity. */
$context['label'] = ! empty( $input_name ) ? sprintf( esc_html__( '%s quantity', 'uni' ), wp_strip_all_tags( $input_name ) ) : esc_html__( 'Quantity', 'uni' );

Timber::render( 'woocommerce/global/quantity-input.html.twig', $context );
