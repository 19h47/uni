<?php
/**
 * Single: product
 *
 * @package UNI
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

use Timber\{ Timber };
use UNI\Models\{ ProductPost };

$context = Timber::get_context();

$context['post'] = new ProductPost();

// Restore the context and loop back to the main query loop 🤔.
wp_reset_postdata();

Timber::render( 'pages/single-product.html.twig', $context );
