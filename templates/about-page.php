<?php
/**
 * Template Name: About page
 *
 * @package uniUNI
 */

global $product;

use Timber\{ Timber };

$context = Timber::get_context();


$context['post'] = Timber::get_post();

$context['post']->modules = array( 'horizontal-page' );

Timber::render( 'pages/about-page.html.twig', $context );
