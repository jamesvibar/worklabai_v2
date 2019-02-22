<?php
global $paged;
if ( !isset($paged) || !$paged ) {
  $paged = 1;
}

$context = Timber::get_context();
$context['post'] = new Timber\Term();

$args = array(
  'posts_per_page' => 3,
  'category_name' => 'education-center',
  'paged' => $paged
);

$context['posts'] = new Timber\PostQuery($args);  

$templates = array('category-education-center.twig', 'index.twig');
Timber::render($templates, $context);