<?php
global $paged;
if ( !isset($paged) || !$paged ) {
  $paged = 1;
}

$context = Timber::get_context();
// $context['post'] = get_the_archive_title();
$context['post'] = "Gallery";
$context['background_image'] = new Timber\Image(295);

$args = array(
  'posts_per_page' => 3,
  'post_type' => 'gallery',
  'paged' => $paged
);

$context['posts'] = new Timber\PostQuery($args);  

$templates = array('archive-gallery.twig', 'index.twig');
Timber::render($templates, $context);