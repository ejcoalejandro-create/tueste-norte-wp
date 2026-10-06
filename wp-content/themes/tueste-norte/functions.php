<?php
/**
 * Child theme Tueste Norte.
 */
function tueste_norte_enqueue_styles() {
	wp_enqueue_style(
		'tueste-norte-style',
		get_stylesheet_uri(),
		array( 'twenty-twenty-one-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'tueste_norte_enqueue_styles' );