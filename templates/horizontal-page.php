<?php
/**
 * Template Name: Horizontal page
 *
 * @package uni
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new Post();

$context['post']->node_type  = 'HorizontalPage';
$context['post']->body_class = array( 'Horizontal-page' );

Timber::render( 'pages/horizontal-page.html.twig', $context );
