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



