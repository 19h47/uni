<?php
/**
 * Product quantity inputs
 *
 * @package UNI/Templates
 */

$context = Timber::get_context();

$context['max_value'] = $max_value;
$context['min_value'] = $min_value;


$context['input'] = array(
	'id'          => $input_id,
	'name'        => $input_name,
	'classes'     => (array) $classes,
	'step'        => $step,
	'value'       => $input_value,
	'placeholder' => $placeholder,
	'inputmode'   => $inputmode,
);

/* translators: %s: Quantity. */
$context['label'] = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'uni' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'uni' );

Timber::render( 'woocommerce/global/quantity-input.html.twig', $context );
