<?php
/**
 * Checkout terms and conditions area.
 *
 * @package UNI/Templates
 * @version 3.4.0
 */

use Timber\{ Timber, Helper };

$context = Timber::get_context();

$context['checkbox'] = array(
	'enabled' => wc_terms_and_conditions_checkbox_enabled(),
	'text'    => Helper::ob_function( 'wc_terms_and_conditions_checkbox_text' ),
);

$context['terms'] = isset( $_POST['terms'] );

Timber::render( 'woocommerce/checkout/terms.html.twig', $context );
