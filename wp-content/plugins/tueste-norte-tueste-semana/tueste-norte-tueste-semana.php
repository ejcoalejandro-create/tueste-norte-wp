<?php
/**
 * Plugin Name: Tueste Norte – Tueste de la semana
 * Description: Permite elegir desde el admin el café destacado de la semana.
 * Version: 1.0.0
 * Author: Tu nombre
 * Text Domain: tueste-norte-tueste-semana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** ACCIÓN: añade la pantalla dentro del menú "Cafés". */
function tn_tueste_menu() {
	if ( ! post_type_exists( 'cafe' ) ) {
		return; // El plugin de cafés no está activo.
	}
	add_submenu_page(
		'edit.php?post_type=cafe',
		'Tueste de la semana',
		'Tueste de la semana',
		'edit_others_posts',
		'tn-tueste-semana',
		'tn_tueste_pantalla'
	);
}
add_action( 'admin_menu', 'tn_tueste_menu' );

/** ACCIÓN: registra el ajuste donde se guarda el ID del café elegido. */
function tn_tueste_registrar_ajuste() {
	register_setting(
		'tn_tueste_grupo',
		'tn_tueste_semana_id',
		array(
			'type'              => 'integer',
			'sanitize_callback' => 'absint',
			'default'           => 0,
		)
	);
}
add_action( 'admin_init', 'tn_tueste_registrar_ajuste' );

/**
 * FILTRO: por defecto, guardar ajustes exige ser administrador.
 * Con esto también puede un Editor (Marta).
 */
function tn_tueste_capacidad() {
	return 'edit_others_posts';
}
add_filter( 'option_page_capability_tn_tueste_grupo', 'tn_tueste_capacidad' );

/** Devuelve el ID del café destacado, o 0 si no hay o no está publicado. */
function tn_tueste_semana_id() {
	$id = (int) get_option( 'tn_tueste_semana_id', 0 );
	if ( $id && 'publish' === get_post_status( $id ) ) {
		return $id;
	}
	return 0;
}

/** FILTRO: añade la clase "es-tueste-semana" al café destacado. */
function tn_tueste_post_class( $clases, $extra, $post_id ) {
	if ( $post_id && tn_tueste_semana_id() === (int) $post_id ) {
		$clases[] = 'es-tueste-semana';
	}
	return $clases;
}
add_filter( 'post_class', 'tn_tueste_post_class', 10, 3 );

/** FILTRO: indica en la API REST cuál es el tueste de la semana. */
function tn_tueste_rest( $respuesta, $post ) {
	$respuesta->data['tueste_semana'] = ( tn_tueste_semana_id() === (int) $post->ID );
	return $respuesta;
}
add_filter( 'rest_prepare_cafe', 'tn_tueste_rest', 10, 2 );

/** Pantalla de administración. */
function tn_tueste_pantalla() {
	if ( ! current_user_can( 'edit_others_posts' ) ) {
		return;
	}

	$actual = (int) get_option( 'tn_tueste_semana_id', 0 );
	$cafes  = get_posts(
		array(
			'post_type'   => 'cafe',
			'numberposts' => -1,
			'orderby'     => 'title',
			'order'       => 'ASC',
		)
	);
	?>
	<div class="wrap">
		<h1>Tueste de la semana</h1>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'tn_tueste_grupo' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tn_tueste_semana_id">Café destacado</label></th>
					<td>
						<select name="tn_tueste_semana_id" id="tn_tueste_semana_id">
							<option value="0">— Ninguno —</option>
							<?php foreach ( $cafes as $cafe ) : ?>
								<option value="<?php echo esc_attr( $cafe->ID ); ?>" <?php selected( $actual, $cafe->ID ); ?>>
									<?php echo esc_html( $cafe->post_title ); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<p class="description">Aparecerá en la pizarra de la portada y marcado en el catálogo.</p>
					</td>
				</tr>
			</table>
			<?php submit_button( 'Guardar' ); ?>
		</form>
	</div>
	<?php
}