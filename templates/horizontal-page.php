<?php
/**
 * Template Name: Horizontal page
 *
 * @package uni
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new Post();

$context['post']->modules      = array( 'horizontal-page' );
$context['post']->body_classes = array( 'Horizontal-page' );

Timber::render( 'pages/horizontal-page.html.twig', $context );
