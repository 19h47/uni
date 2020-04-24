<?php
/**
 * Template Name: Cart
 *
 * @package uni
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new Post();

Timber::render( 'pages/cart-page.html.twig', $context );
