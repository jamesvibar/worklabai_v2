<?php
global $paged;
if (!isset($paged) || !$paged) {
  $paged = 1;
}

$context = Timber::get_context();
$context['post'] = new Timber\Term();

$args = array(
  'post_type' => 'post',
  'posts_per_page' => 3,
  'category_name' => 'personal',
  'paged' => $paged
);

$context['posts'] = new Timber\PostQuery($args);  

$templates = array('category-child.twig', 'index.twig');
Timber::render($templates, $context);