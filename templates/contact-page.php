<?php
/**
 * Template Name: Contact page
 *
 * @package uni
 */

use Timber\{ Timber, Post };

$context = Timber::get_context();

$context['post'] = new Post();

$context['post']->node_type    = 'HorizontalPage';
$context['post']->body_classes = array( 'Contact-page', 'Horizontal-page' );

Timber::render( 'pages/contact-page.html.twig', $context );
