<?php

/**
 * Load composer dependencies.
 */
require_once WP_CONTENT_DIR . '/vendor/autoload.php';


/**
 * Load extended functions.
 */
require_once get_template_directory() . '/inc/idkomm_functions.php';


/**
 * Include custom actions and filters.
 */
require_once get_template_directory() . '/inc/_actions.php';
require_once get_template_directory() . '/inc/_filters.php';
if (file_exists( get_template_directory() . '/inc/_customizer.php' )) {
	require_once get_template_directory() . '/inc/_customizer.php';
}
if (file_exists( get_template_directory() . '/inc/_colours.php' )) {
	require_once get_template_directory() . '/inc/_colours.php';
}


/**
 * Include Timber specific settings.
 */
require_once get_template_directory() . '/inc/_timber.php';


/**
 * Initialize Timber
 */
$timber = new \Timber\Timber( );

/* CPT */

function cptui_register_my_cpts() {

	/**
	 * Post Type: Recipes.
	 */

	$labels = [
		"name" => __( "Recipes", "custom-post-type-ui" ),
		"singular_name" => __( "Recipe", "custom-post-type-ui" ),
		"menu_name" => __( "My Recipes", "custom-post-type-ui" ),
		"all_items" => __( "All Recipes", "custom-post-type-ui" ),
		"add_new" => __( "Add new", "custom-post-type-ui" ),
		"add_new_item" => __( "Add new Recipe", "custom-post-type-ui" ),
		"edit_item" => __( "Edit Recipe", "custom-post-type-ui" ),
		"new_item" => __( "New Recipe", "custom-post-type-ui" ),
		"view_item" => __( "View Recipe", "custom-post-type-ui" ),
		"view_items" => __( "View Recipes", "custom-post-type-ui" ),
		"search_items" => __( "Search Recipes", "custom-post-type-ui" ),
		"not_found" => __( "No Recipes found", "custom-post-type-ui" ),
		"not_found_in_trash" => __( "No Recipes found in trash", "custom-post-type-ui" ),
		"parent" => __( "Parent Recipe:", "custom-post-type-ui" ),
		"featured_image" => __( "Featured image for this Recipe", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set featured image for this Recipe", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove featured image for this Recipe", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use as featured image for this Recipe", "custom-post-type-ui" ),
		"archives" => __( "Recipe archives", "custom-post-type-ui" ),
		"insert_into_item" => __( "Insert into Recipe", "custom-post-type-ui" ),
		"uploaded_to_this_item" => __( "Upload to this Recipe", "custom-post-type-ui" ),
		"filter_items_list" => __( "Filter Recipes list", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Recipes list navigation", "custom-post-type-ui" ),
		"items_list" => __( "Recipes list", "custom-post-type-ui" ),
		"attributes" => __( "Recipes attributes", "custom-post-type-ui" ),
		"name_admin_bar" => __( "Recipe", "custom-post-type-ui" ),
		"item_published" => __( "Recipe published", "custom-post-type-ui" ),
		"item_published_privately" => __( "Recipe published privately.", "custom-post-type-ui" ),
		"item_reverted_to_draft" => __( "Recipe reverted to draft.", "custom-post-type-ui" ),
		"item_scheduled" => __( "Recipe scheduled", "custom-post-type-ui" ),
		"item_updated" => __( "Recipe updated.", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Parent Recipe:", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Recipes", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "recipes", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "custom-fields" ],
	];

	register_post_type( "recipes", $args );

	/**
	 * Post Type: Products.
	 */

	$labels = [
		"name" => __( "Products", "custom-post-type-ui" ),
		"singular_name" => __( "Product", "custom-post-type-ui" ),
		"menu_name" => __( "My Products", "custom-post-type-ui" ),
		"all_items" => __( "All Products", "custom-post-type-ui" ),
		"add_new" => __( "Add new", "custom-post-type-ui" ),
		"add_new_item" => __( "Add new Product", "custom-post-type-ui" ),
		"edit_item" => __( "Edit Product", "custom-post-type-ui" ),
		"new_item" => __( "New Product", "custom-post-type-ui" ),
		"view_item" => __( "View Product", "custom-post-type-ui" ),
		"view_items" => __( "View Products", "custom-post-type-ui" ),
		"search_items" => __( "Search Products", "custom-post-type-ui" ),
		"not_found" => __( "No Products found", "custom-post-type-ui" ),
		"not_found_in_trash" => __( "No Products found in trash", "custom-post-type-ui" ),
		"parent" => __( "Parent Product:", "custom-post-type-ui" ),
		"featured_image" => __( "Featured image for this Product", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set featured image for this Product", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove featured image for this Product", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use as featured image for this Product", "custom-post-type-ui" ),
		"archives" => __( "Product archives", "custom-post-type-ui" ),
		"insert_into_item" => __( "Insert into Product", "custom-post-type-ui" ),
		"uploaded_to_this_item" => __( "Upload to this Product", "custom-post-type-ui" ),
		"filter_items_list" => __( "Filter Products list", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Products list navigation", "custom-post-type-ui" ),
		"items_list" => __( "Products list", "custom-post-type-ui" ),
		"attributes" => __( "Products attributes", "custom-post-type-ui" ),
		"name_admin_bar" => __( "Product", "custom-post-type-ui" ),
		"item_published" => __( "Product published", "custom-post-type-ui" ),
		"item_published_privately" => __( "Product published privately.", "custom-post-type-ui" ),
		"item_reverted_to_draft" => __( "Product reverted to draft.", "custom-post-type-ui" ),
		"item_scheduled" => __( "Product scheduled", "custom-post-type-ui" ),
		"item_updated" => __( "Product updated.", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Parent Product:", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Products", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "products", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "custom-fields" ],
	];

	register_post_type( "products", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );


