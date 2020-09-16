<?php

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['product'] = get_field($post->ID);
$context['recipe'] = get_field($post->ID);


// recipe connection
$args_product = array(
// Get post type project
'post_type' => 'products',
// Get all posts
'posts_per_page' => -1,
// Order by post date
'orderby' => array(
    'date' => 'ASC'
));

$context['products'] = Timber::get_posts( $args_product );
/* $repeater = $post->get_field( 'recipe_ingredients' ); */


// recipe connection
$args_recipes = array(
    // Get post type project
    'post_type' => 'recipes',
    // Get all posts
    'posts_per_page' => -1,
    // Order by post date
    'orderby' => array(
        'date' => 'ASC'
    ));
    
    $context['recipes'] = Timber::get_posts( $args_recipes );
    /* $repeater = $post->get_field( 'recipe_ingredients' ); */


if ( post_password_required( $post->ID ) ) {
    Timber::render( 'single/single-password.twig', $context );
} else {
    Timber::render( array(
        'single/single-' . $post->ID . '.twig',
        'single/single-' . $post->post_type . '.twig',
        'single/single.twig'
    ), $context );
}