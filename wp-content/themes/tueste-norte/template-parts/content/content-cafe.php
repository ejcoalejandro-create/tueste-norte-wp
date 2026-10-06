<?php
/**
 * Ficha de café (categoría Cafés).
 * Comprueba campos vacíos y escapa toda la salida.
 */

// Si ACF se desactiva, la web no se rompe: simplemente no hay ficha.
$tiene_acf = function_exists( 'get_field' );

$origen = $tiene_acf ? get_field( 'origen' ) : '';
$notas  = $tiene_acf ? get_field( 'notas_de_cata' ) : '';
$tueste = $tiene_acf ? get_field( 'nivel_tueste' ) : '';
$precio = $tiene_acf ? get_field( 'precio' ) : '';

$niveles = array(
	'claro'  => 'Claro',
	'medio'  => 'Medio',
	'oscuro' => 'Oscuro',
);
$tueste_texto = isset( $niveles[ $tueste ] ) ? $niveles[ $tueste ] : '';
$tiene_precio = is_numeric( $precio );
$hay_ficha    = $origen || $notas || $tueste_texto || $tiene_precio;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large' ); ?>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>

		<?php if ( $hay_ficha ) : ?>
			<section class="ficha-cafe">
				<dl>
					<?php if ( $origen ) : ?>
						<dt>Origen</dt>
						<dd><?php echo esc_html( $origen ); ?></dd>
					<?php endif; ?>

					<?php if ( $notas ) : ?>
						<dt>Notas de cata</dt>
						<dd><?php echo nl2br( esc_html( $notas ) ); ?></dd>
					<?php endif; ?>

					<?php if ( $tueste_texto ) : ?>
						<dt>Nivel de tueste</dt>
						<dd><?php echo esc_html( $tueste_texto ); ?></dd>
					<?php endif; ?>

					<?php if ( $tiene_precio ) : ?>
						<dt>Precio</dt>
						<dd class="ficha-precio">
							<?php echo esc_html( number_format_i18n( (float) $precio, 2 ) ); ?> € / 250 g
						</dd>
					<?php endif; ?>
				</dl>
			</section>
		<?php endif; ?>
	</div>

</article>