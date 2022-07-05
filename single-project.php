<?php
/**
 * Single: project
 *
 * @package UNI
 */

use Timber\{ Timber };

$data         = Timber::get_context();
$data['post'] = Timber::get_post();

Timber::render( 'pages/single-project.html.twig', $data );
