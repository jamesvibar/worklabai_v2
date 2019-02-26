<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */
global $wp_query;

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );

$context = Timber::get_context();
$context['title'] = 'Search';
$context['background_image'] = new Timber\Image(163);

$context['posts'] = new Timber\PostQuery();
$context['query'] = get_search_query();
$context['found_posts'] = $wp_query->found_posts;

Timber::render( $templates, $context );
