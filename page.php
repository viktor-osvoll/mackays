<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

Timber::render( array(
        'page/page-' . $post->post_name . '.twig',
        'page/page.twig'
    ), $context
);