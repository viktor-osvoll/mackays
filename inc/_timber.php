<?php

/**
 * Expose Kint debug function.
 */
add_filter( 'timber/twig', function ( \Twig_Environment $twig ) {
	$twig->addFunction( new Timber\Twig_Function( 'd', function ( $var ) {
		return @d( $var );
	} ) );

	return $twig;
} );


/**
 * Google Tag Manager
 */
add_filter( 'timber/twig', function ( \Twig_Environment $twig ) {
	$twig->addFunction( new Timber\Twig_Function( 'idkomm_add_GTM', function () {
		return idkomm_add_GTM();
	} ) );
	$twig->addFunction( new Timber\Twig_Function( 'idkomm_add_GTM_noscript', function () {
		return idkomm_add_GTM_noscript();
	} ) );

	return $twig;
} );


/**
 * Standard Menu
 */
add_filter( 'timber/context', function ( $context ) {
	$context['menu'] = new \Timber\Menu( 'primary' );

	return $context;
} );