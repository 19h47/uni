<?php
/**
 * Template Name: Cart page
 *
 * @package uni
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 0.0.0
 * @version 0.0.0
 */

use Timber\{ Timber };

$templates = array( 'pages/cart-page.html.twig' );

$data                       = Timber::context();
$data['post']               = Timber::get_post();
$data['namespace']          = 'page';
$data['post']->body_classes = array( 'Cart' );

Timber::render( $templates, $data );
