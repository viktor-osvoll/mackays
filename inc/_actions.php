<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function idkomm_theme_setup() {

	/**
	 * WordPress - Load translations
	 */
	load_theme_textdomain( 'idkomm', get_template_directory() . '/languages' );

	/**
	 * WordPress - Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * WordPress - Handle the <title> tag.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * WordPress - Enable featured image
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * WordPress - Custom menu support
	 */
	add_theme_support( 'menus' );

	/**
	 * Gutenberg - Align-wide setting
	 */
	add_theme_support( 'align-wide' );

	/**
	 * Gutenberg - Color settings
	 */
	if (function_exists('idkomm_get_colour_palette')) {
		add_theme_support( 'editor-color-palette', idkomm_get_colour_palette( 'EditorColourPalette' ) );
	} else {
		add_theme_support( 'editor-color-palette', [
			[
				'name'  => __( 'Dusty', 'idkomm' ),
				'slug'  => 'dusty',
				'color' => '#96858F',
			],
			[
				'name'  => __( 'Lavender', 'idkomm' ),
				'slug'  => 'lavender',
				'color' => '#6D7993',
			],
			[
				'name'  => __( 'Overcast', 'idkomm' ),
				'slug'  => 'overcast',
				'color' => '#9099A2',
			],
			[
				'name'  => __( 'Paper', 'idkomm' ),
				'slug'  => 'paper',
				'color' => '#D5D5D5',
			],
		] );
	}

	/**
	 * Gutenberg - Disable custom color picker
	 */
	add_theme_support( 'disable-custom-colors' );

}

add_action( 'after_setup_theme', 'idkomm_theme_setup' );


/**
 * Load Gutenberg editor stylesheet.
 */
function idkomm_gutenberg_editor_style() {
	wp_enqueue_style( 'idkomm-gutenberg-editor', get_theme_file_uri( '/style-editor.css' ), FALSE );
}

add_action( 'enqueue_block_editor_assets', 'idkomm_gutenberg_editor_style' );


/**
 * Enqueue scripts and styles. Some third party tools might be baked in through
 * gulp. Check webpack.config.js
 */
function idkomm_enqueue_scripts() {
	$dist_path = '/resources/dist/';

	$main_css      = $dist_path . 'app.css';
	$main_js       = $dist_path . 'app.js';
	$customizer_js = $dist_path . 'customizer.js';

	wp_enqueue_style( 'idkomm-css', get_template_directory_uri() . $main_css );
	wp_enqueue_script( 'idkomm-js', get_template_directory_uri() . $main_js );
	wp_enqueue_script( 'customizer-js', get_template_directory_uri() . $customizer_js, [ 'jquery','customize-preview' ], '', true );

	$t10ns = [
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	];
	wp_localize_script( 'idkomm-js', 'idkomm', $t10ns );

}

add_action( 'wp_enqueue_scripts', 'idkomm_enqueue_scripts' );

/**
 * Enqueue admin scripts and styles
 *
 * uncomment action to enable
 *
 * @return  null
 */
function idkomm_admin_styles() {
	$dist_path = '/resources/dist/';

	$admin_css      = $dist_path . 'admin.css';
	$admin_js       = $dist_path . 'admin.js';

	wp_enqueue_style( 'idkomm-admin-css', get_template_directory_uri() . $admin_css, false, '1.0.0' );
	wp_enqueue_script( 'idkomm-admin-js', get_template_directory_uri() . $admin_js, false, '1.0.0' );
}
// add_action( 'admin_enqueue_scripts', 'idkomm_admin_styles' );



/**
 * If this is a dev environment, look for Kint in vendors dir and include if
 * found Else raise a flag
 *
 * d( $var ); prints a dump of $var
 * ddd( $var ); same only it die(s) after
 *
 * @see http://kint-php.github.io/kint/
 */
add_action( 'init', function () {
	$vendor_path = preg_replace( '/wp/', 'content/vendor', ABSPATH );

	if ( TRUE === idkomm_is_dev() ) {
		$path_to_kint = $vendor_path . 'kint-php/kint/Kint.class.php';
		if ( TRUE === file_exists( $path_to_kint ) ) {
			require_once $path_to_kint;
		} else {
			add_action( 'admin_notices',
				function () {
					$class   = "error";
					$message = "Could not find Kint in Vendors dir, please check your Composer file";
					echo "<div class=\"$class\"> <p>$message</p></div>";
				} );
		}
	}

	// Catch any stray calls to d() if Kint is not loaded
	if ( ! function_exists( 'd' ) ) {
		function d() {
			return;
		}
	}
} );


/**
 * Make available a kitchen sink for element styling.
 */
function idkomm_kitchen_sink_url_intercept() {
	$url_clean = str_replace( '/', '', $_SERVER['REQUEST_URI'] );

	if ( $url_clean == 'kitchen-sink' ) {
		$load = locate_template( 'kitchen-sink.php', TRUE );
	}

	if ( isset( $load ) && $load ) {
		exit();
	}
}

add_action( 'init', 'idkomm_kitchen_sink_url_intercept' );
