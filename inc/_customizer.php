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

	$wp_customize->remove_section( 'themes' );
	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_section( 'nav' );
	$wp_customize->remove_section( 'nav_menus' );
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'custom_css' );
	$wp_customize->remove_section( 'widgets' );


	$wp_customize->add_section( 'idkomm_contact_info', [
		'title'    => __( 'Contact information', 'idkomm' ),
		'priority' => 20,
	] );

	$wp_customize->add_section( 'idkomm_footer_settings', [
		'title'    => __( 'Footer Settings', 'idkomm' ),
		'priority' => 40,
	] );

	$wp_customize->add_section( 'idkomm_google_settings', [
		'title'    => __( 'Google Account settings', 'idkomm' ),
		'priority' => 30,
	] );



	$wp_customize->add_setting( 'idkomm_contact_info_address', 
		array( 'default' => '', 'sanitize_callback' => 'wp_kses_post', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'idkomm_contact_info_address', [
		'label'             => __( 'Company Address', 'idkomm' ),
		'type'              => 'textarea',
		'description'       => __( 'A physical address', 'idkomm' ),
		'section'           => 'idkomm_contact_info',
		'priority'          => 2,
	] );

	$wp_customize->add_setting( 'idkomm_google_tag_manager_code', 
		array( 'default' => 'GTM-XXXX', 'sanitize_callback' => '', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'idkomm_google_tag_manager_code', [
		'label'             => __( 'Google Tag Manager Code', 'idkomm' ),
		'type'              => 'text',
		'description'       => __( 'The code should only be of the format GTM-XXXX.', 'idkomm' ),
		'section'           => 'idkomm_google_settings',
		'priority'          => 2,
	] );

	$wp_customize->add_setting( 'idkomm_google_maps_api_key', 
		array( 'default' => 'NNNNNNNNNNNNNNNN', 'sanitize_callback' => '', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'idkomm_google_maps_api_key', [
		'label'             => __( 'Google Maps API Key', 'idkomm' ),
		'type'              => 'text',
		'description'       => __( 'You need one of these with billing enabled', 'idkomm' ),
		'section'           => 'idkomm_google_settings',
		'priority'          => 3,
	] );

	$wp_customize->add_setting( 'idkomm_selector', 
		array( 'default' => 'B', 'sanitize_callback' => '', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'idkomm_selector', [
		'label'             => __( 'Select box', 'idkomm' ),
		'type'              => 'select',
		'description'       => __( 'has choices', 'idkomm' ),
		'choices'           => ["A" => "A", "B" => "B", "C" => "C", ],
		'section'           => 'idkomm_contact_info',
		'priority'          => 3,
	] );

	$wp_customize->add_setting( 'idkomm_footer_text_colour', 
		array( 'default' => '#FFFFFF', 'sanitize_callback' => '', 'transport' => 'postMessage' ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 
			'idkomm_footer_text_colour',
			array(
			'label'             => __( 'Text colour', 'idkomm' ),
			'description'       => __( 'Pick a colour, any colour', 'idkomm' ),
			'choices'           => '',
			'section'           => 'idkomm_footer_settings',
			'priority'          => 4,
		) )
	);

	$wp_customize->add_setting( 'idkomm_footer_background_colour', 
		array( 'default' => '#000000', 'sanitize_callback' => '', 'transport' => 'postMessage' ) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 
			'idkomm_footer_background_colour',
			array(
			'label'             => __( 'Background colour', 'idkomm' ),
			'description'       => __( 'Pick a colour, any colour', 'idkomm' ),
			'choices'           => '',
			'section'           => 'idkomm_footer_settings',
			'priority'          => 5,
		) )
	);

	$wp_customize->add_setting( 'idkomm_footer_image', 
		array( 'default' => '', 'sanitize_callback' => '', 'transport' => 'postMessage' ) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 
			'idkomm_footer_image',
			array(
			'label'             => __( 'Image', 'idkomm' ),
			'description'       => __( 'Pick an image', 'idkomm' ),
			'choices'           => '',
			'section'           => 'idkomm_footer_settings',
			'priority'          => 6,
		) )
	);

	$wp_customize->add_setting( 'idkomm_footer_attachment', 
		array( 'default' => '', 'sanitize_callback' => '', 'transport' => 'postMessage' ) );
	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize, 
			'idkomm_footer_attachment',
			array(
			'label'             => __( 'Attachment', 'idkomm' ),
			'description'       => __( 'Pick a file', 'idkomm' ),
			'choices'           => '',
			'section'           => 'idkomm_footer_settings',
			'priority'          => 7,
		) )
	);


}

add_action( 'customize_register', 'idkomm_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function idkomm_customize_preview_js() {
	wp_enqueue_script( 'idkomm_customizer', get_template_directory_uri() . '/resources/dist/js/customizer.js', array( 'customize-preview' ), '', true );
}

add_action( 'customize_preview_init', 'idkomm_customize_preview_js' );


/**
 * @return string
 */
function idkomm_get_contact_info_address() {
	return get_theme_mod( 'idkomm_contact_info_address' );
}

/**
 * @return string
 */
function idkomm_get_google_tag_manager_code() {
	return get_theme_mod( 'idkomm_google_tag_manager_code' );
}

/**
 * @return string
 */
function idkomm_get_google_maps_api_key() {
	return get_theme_mod( 'idkomm_google_maps_api_key' );
}

/**
 * @return string
 */
function idkomm_get_selector() {
	return get_theme_mod( 'idkomm_selector' );
}

/**
 * @return string
 */
function idkomm_get_footer_text_colour() {
	return get_theme_mod( 'idkomm_footer_text_colour' );
}

/**
 * @return string
 */
function idkomm_get_footer_background_colour() {
	return get_theme_mod( 'idkomm_footer_background_colour' );
}

/**
 * @return string
 */
function idkomm_get_footer_image() {
	return get_theme_mod( 'idkomm_footer_image' );
}

/**
 * @return string
 */
function idkomm_get_footer_attachment() {
	return get_theme_mod( 'idkomm_footer_attachment' );
}


/**
 * Register theme mod getters with Twig
 */
add_filter( 'timber/twig', function ( \Twig_Environment $twig ) {
	$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_contact_info_address', function () {
		return idkomm_get_contact_info_address();
	} ) );

	$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_google_tag_manager_code', function () {
		return idkomm_get_google_tag_manager_code();
	} ) );

	$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_google_maps_api_key', function () {
		return idkomm_get_google_maps_api_key();
	} ) );

	$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_selector', function () {
		return idkomm_get_selector();
	} ) );

	$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_footer_text_colour', function () {
		return idkomm_get_footer_text_colour();
	} ) );

	$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_footer_background_colour', function () {
		return idkomm_get_footer_background_colour();
	} ) );

	$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_footer_image', function () {
		return idkomm_get_footer_image();
	} ) );

	$twig->addFunction( new Timber\Twig_Function( 'idkomm_get_footer_attachment', function () {
		return idkomm_get_footer_attachment();
	} ) );


	return $twig;
} );