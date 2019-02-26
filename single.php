<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['background_image'] = new Timber\Image(165);

$category = $post->category;
$args = array(
	'category__in' => $category->id,
	'post__not_in' => array($post->ID),
	'posts_per_page' => 3,
	'ignore_sticky_posts' => true,
	'order' => 'ASC'
);

$context['related_posts'] = new Timber\PostQuery($args);


if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}
