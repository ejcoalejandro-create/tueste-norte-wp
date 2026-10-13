<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tn_tema_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array( 'principal' => 'Menú principal' ) );
}
add_action( 'after_setup_theme', 'tn_tema_setup' );

function tn_tema_estilos() {
	wp_enqueue_style( 'tn-estilos', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'tn_tema_estilos' );