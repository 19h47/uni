<?php
/**
 * Template Name: Archive page
 *
 * @package uniUNI
 */

global $product;

use Timber\{ Timber };

$context = Timber::get_context();


$context['post'] = Timber::get_post();

$context['post']->body_classes = array( 'Archive-page' );
$context['post']->node_type    = 'HorizontalPage';

Timber::render( 'pages/archive-page.html.twig', $context );
