<?php
/**
 * Single: project
 *
 * @package uni
 */

use Timber\{ Timber, Post };
use UNI\Models\{ ProjectPost };

$context = Timber::get_context();

$context['post'] = new ProjectPost();

Timber::render( 'pages/single-project.html.twig', $context );
