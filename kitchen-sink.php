<?php

// No sink outside dev
if (!idkomm_is_dev()) {
	wp_safe_redirect( home_url() );
}

$context = Timber::get_context();
Timber::render( 'kitchen-sink.twig', $context );