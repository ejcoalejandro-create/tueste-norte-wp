<?php get_header(); ?>

<?php
while ( have_posts() ) :
	the_post();

	$tiene_acf = function_exists( 'get_field' );
	$origen    = $tiene_acf ? get_field( 'origen' ) : '';
	$notas     = $tiene_acf ? get_field( 'notas_cata' ) : '';
	$tueste    = $tiene_acf ? get_field( 'nivel_tueste' ) : '';
	$precio    = $tiene_acf ? get_field( 'precio' ) : '';

	$niveles      = array( 'claro' => 'Claro', 'medio' => 'Medio', 'oscuro' => 'Oscuro' );
	$tueste_texto = isset( $niveles[ $tueste ] ) ? $niveles[ $tueste ] : '';
	$tiene_precio = is_numeric( $precio );
	?>
	<article <?php post_class( 'pagina' ); ?>>
		<h1 class="titulo-pagina"><?php the_title(); ?></h1>

		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large' ); ?>
		<?php endif; ?>

		<div class="texto"><?php the_content(); ?></div>

		<?php if ( $origen || $notas || $tueste_texto || $tiene_precio ) : ?>
			<dl class="ficha">
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
					<dd class="ficha__precio"><?php echo esc_html( number_format_i18n( (float) $precio, 2 ) ); ?> € / 250 g</dd>
				<?php endif; ?>
			</dl>
		<?php endif; ?>

		<p><a href="<?php echo esc_url( get_post_type_archive_link( 'cafe' ) ); ?>">← Ver todos los cafés</a></p>
	</article>
<?php endwhile; ?>

<?php get_footer(); ?>