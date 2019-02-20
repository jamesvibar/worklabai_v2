<?php

$context = Timber::get_context();

// Get post data
$context['post'] = new Timber\Post;

Timber::render('page-front-page.twig', $context);