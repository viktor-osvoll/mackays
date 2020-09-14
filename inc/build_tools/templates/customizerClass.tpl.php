<?php
/*******************************************************************************
 * ID Kommunikation Theme Customizer
 *
 * Change settings in theme_config.json
 * then run npm build to affect changes to this file
 *
 * @package idkomm
 ******************************************************************************/


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function idkomm_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

/**REMOVE_SECTIONS**/

/**ADD_SECTIONS**/

/**ADD_CONTROLS**/
}

add_action( 'customize_register', 'idkomm_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function idkomm_customize_preview_js() {
	wp_enqueue_script( 'idkomm_customizer', get_template_directory_uri() . '/resources/dist/js/customizer.js', array( 'customize-preview' ), '', true );
}

add_action( 'customize_preview_init', 'idkomm_customize_preview_js' );


/**ADD_GETTERS**/
/**
 * Register theme mod getters with Twig
 */
add_filter( 'timber/twig', function ( \Twig_Environment $twig ) {
/**ADD_TWIG_FILTERS**/
	return $twig;
} );