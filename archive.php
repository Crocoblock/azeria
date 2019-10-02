<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package azeria
 */

get_header();

azeria_do_location( 'archive', 'template-parts/archive' );

get_footer();
