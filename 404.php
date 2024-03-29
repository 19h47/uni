<?php
/**
 * 404
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package WordPress
 * @subpackage UNI
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 0.0.0
 * @version 0.0.0
 */

use Timber\{ Timber };

$templates = array( 'pages/404.html.twig' );

$data                    = Timber::context();
$data['post']            = Timber::get_post();
$data['post']['title']   = __( 'Nothing here', 'uni' );
$data['post']['content'] = __( 'It looks like nothing was found at this location. Maybe try a search?', 'uni' );
$data['namespace']       = 'page';

Timber::render( $templates, $data );
