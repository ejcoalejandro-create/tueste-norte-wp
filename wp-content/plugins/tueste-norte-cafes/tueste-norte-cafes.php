<?php
/**
 * Plugin Name: Tueste Norte – Cafés
 * Description: Registra el tipo de contenido "Café" y lo expone por la API REST.
 * Version: 1.0.0
 * Author: Tu nombre
 * Text Domain: tueste-norte-cafes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tn_cafes_registrar_cpt() {
	$etiquetas = array(
		'name'               => 'Cafés',
		'singular_name'      => 'Café',
		'menu_name'          => 'Cafés',
		'all_items'          => 'Todos los cafés',
		'add_new'            => 'Añadir café',
		'add_new_item'       => 'Añadir nuevo café',
		'edit_item'          => 'Editar café',
		'view_item'          => 'Ver café',
		'search_items'       => 'Buscar cafés',
		'not_found'          => 'No hay cafés',
		'not_found_in_trash' => 'No hay cafés en la papelera',
	);

	register_post_type(
		'cafe',
		array(
			'labels'        => $etiquetas,
			'public'        => true,
			'has_archive'   => 'cafes',
			'rewrite'       => array( 'slug' => 'cafes' ),
			'menu_icon'     => 'dashicons-products',
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'show_in_rest'  => true,
			'rest_base'     => 'cafes',
		)
	);
}
add_action( 'init', 'tn_cafes_registrar_cpt' );

/**
 * Añade a la respuesta REST un campo "ficha" con los datos del ACF
 * y la URL de la imagen destacada.
 */
function tn_cafes_registrar_campo_rest() {
	register_rest_field(
		'cafe',
		'ficha',
		array(
			'get_callback' => 'tn_cafes_ficha_rest',
			'schema'       => array(
				'description' => 'Datos de la ficha del café',
				'type'        => 'object',
			),
		)
	);
}
add_action( 'rest_api_init', 'tn_cafes_registrar_campo_rest' );

function tn_cafes_ficha_rest( $objeto ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	$id     = (int) $objeto['id'];
	$precio = get_field( 'precio', $id );
	$imagen = get_the_post_thumbnail_url( $id, 'large' );

	return array(
		'origen'       => get_field( 'origen', $id ),
		'notas_cata'   => get_field( 'notas_cata', $id ),
		'nivel_tueste' => get_field( 'nivel_tueste', $id ),
		'precio'       => is_numeric( $precio ) ? (float) $precio : null,
		'imagen'       => $imagen ? $imagen : null,
	);
}

/**
 * Al activar: registrar el CPT y regenerar las rutas.
 * Sin esto, las URLs de los cafés dan 404.
 */
function tn_cafes_activar() {
	tn_cafes_registrar_cpt();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'tn_cafes_activar' );

function tn_cafes_desactivar() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'tn_cafes_desactivar' );