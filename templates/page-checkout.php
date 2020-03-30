<?php
/**
 * Template Name: Checkout
 *
 * @package UNI
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new Post();

Timber::render( 'pages/page-checkout.html.twig', $context );
