<?php
/**
 * Template Name: Archive page
 *
 * @package uniUNI
 */

global $product;

use Timber\{ Timber };

$data         = Timber::get_context();
$data['post'] = Timber::get_post();

Timber::render( 'pages/archive-page.html.twig', $data );
