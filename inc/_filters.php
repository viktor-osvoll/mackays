<?php

/**
 * Filter the excerpt length to 20 characters.
 *
 * @param int $length Excerpt length.
 *
 * @return int (Maybe) modified excerpt length.
 */
add_filter('excerpt_length', function ($lenght) {
	return 20;
}, 999);


/**
 * Add Polylang support to Customizer
 */
// add_filter( 'scp_js_path_url', function ( $path_url ) {
// 	$path_url = get_stylesheet_directory_uri() . '/vendor/soderlind/customizer-polylang/js';
// 	return $path_url;
// } );
