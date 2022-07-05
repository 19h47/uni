<?php
/**
 * Template Name: Horizontal page
 *
 * @package uni
 */

use Timber\{ Timber };

$data                       = Timber::context();
$data['post']               = Timber::get_post();
$data['post']->modules      = array( 'horizontal-page' );
$data['post']->body_classes = array( 'Horizontal-page' );

Timber::render( 'pages/horizontal-page.html.twig', $data );
