<?php
/**
 * Template Name: About page
 *
 * @package uniUNI
 */

global $product;

use Timber\{ Timber };

$data                  = Timber::get_context();
$data['post']          = Timber::get_post();
$data['post']->modules = array( 'horizontal-page' );

Timber::render( 'pages/about-page.html.twig', $data );
