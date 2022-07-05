<?php
/**
 * Template Name: Contact page
 *
 * @package uni
 */

use Timber\{ Timber };

$data                  = Timber::get_context();
$data['post']          = Timber::get_post();
$data['post']->modules = array( 'contact-page' );

Timber::render( 'pages/contact-page.html.twig', $data );
