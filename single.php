<?php

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;

if ( post_password_required( $post->ID ) ) {
    Timber::render( 'single/single-password.twig', $context );
} else {
    Timber::render( array(
        'single/single-' . $post->ID . '.twig',
        'single/single-' . $post->post_type . '.twig',
        'single/single.twig'
    ), $context );
}