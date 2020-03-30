<?php
/**
 * Template Name: Cart
 *
 * @package WordPress
 * @subpackage UNI
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new Post();

Timber::render( 'pages/page-cart.html.twig', $context );
