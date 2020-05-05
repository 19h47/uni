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

use Timber\{ Timber, Post };

$context = Timber::context();

$context['post']      = new Post();
$context['namespace'] = 'page';

$context['post']->body_classes = array( 'Cart' );

$templates = array( 'pages/cart-page.html.twig' );

Timber::render( $templates, $context );
