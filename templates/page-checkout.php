<?php
/**
 * Template Name: Checkout
 *
 * @package uni
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new Post();

Timber::render( 'pages/checkout-page.html.twig', $context );
