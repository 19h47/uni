<?php
/**
 * Template Name: Archive page
 *
 * @package uniUNI
 */

global $product;

use Timber\{ Timber };
use UNI\Models\{ ArchivePage };

$data = Timber::get_context();

$data['post'] = new ArchivePage();

Timber::render( 'pages/archive-page.html.twig', $data );
