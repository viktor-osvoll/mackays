<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['collumn'] = get_fields(199);
$context['fields'] = get_fields(10);


Timber::render( array(
        'page/page-' . $post->post_name . '.twig',
        'page/competition.twig'
    ), $context
);