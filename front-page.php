<?php
/**
 * Front page
 *
 * @package uni
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 0.0.0
 * @version 0.0.0
 */

use Timber\{ Timber };

$templates = array( 'pages/front-page.html.twig' );

$data                       = Timber::context();
$data['post']               = Timber::get_post();
$data['namespace']          = 'front-page';
$data['post']->modules      = array( 'front-page' );
$data['post']->body_classes = array( 'modal--is-open' );

Timber::render( $templates, $data );
