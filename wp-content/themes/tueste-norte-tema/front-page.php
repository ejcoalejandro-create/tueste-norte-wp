<?php get_header(); ?>

<?php
$id_tueste = function_exists( 'tn_tueste_semana_id' ) ? tn_tueste_semana_id() : 0;

if ( $id_tueste ) :
	$origen = function_exists( 'get_field' ) ? get_field( 'origen', $id_tueste ) : '';
	$notas  = function_exists( 'get_field' ) ? get_field( 'notas_cata', $id_tueste ) : '';
	?>
	<section class="pizarra">
		<p class="pizarra__etiqueta">Tueste de la semana</p>
		<h2 class="pizarra__titulo">
			<a href="<?php echo esc_url( get_permalink( $id_tueste ) ); ?>"><?php echo esc_html( get_the_title( $id_tueste ) ); ?></a>
		</h2>
		<?php if ( $origen ) : ?>
			<p><?php echo esc_html( $origen ); ?></p>
		<?php endif; ?>
		<?php if ( $notas ) : ?>
			<p><?php echo esc_html( $notas ); ?></p>
		<?php endif; ?>
	</section>
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div class="texto"><?php the_content(); ?></div>
<?php endwhile; ?>

<p><a href="<?php echo esc_url( get_post_type_archive_link( 'cafe' ) ); ?>">Ver todos los cafés →</a></p>

<?php get_footer(); ?>