<?php
$context = Timber::get_context();
$context['posts'] = new Timber\PostQuery();
$context['foo'] = 'bar';
$context['fields'] = get_fields(10);

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


// Product connection

$args_products = array(
    // Get post type project
    'post_type' => 'products',
    // Get all posts
    'posts_per_page' => 6,
    // Order by post date
    'orderby' => array(
        'date' => 'ASC'
    ));
    
    $context['products'] = Timber::get_posts( $args_products );
    /* $repeater = $post->get_field( 'recipe_ingredients' ); */


$templates = array( 'index.twig' );

if ( is_home() ) {
    array_unshift( $templates, 'home.twig' );
}

Timber::render( $templates, /* 'layouts/recipe.twig', */ $context );