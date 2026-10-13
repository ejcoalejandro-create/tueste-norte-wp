<?php get_header(); ?>

<h1 class="titulo-pagina"><?php post_type_archive_title(); ?></h1>

<?php if ( have_posts() ) : ?>
	<div class="cafes-grid">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			$origen = function_exists( 'get_field' ) ? get_field( 'origen' ) : '';
			$precio = function_exists( 'get_field' ) ? get_field( 'precio' ) : '';
			?>
			<article <?php post_class( 'cafe-tarjeta' ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a>
				<?php endif; ?>
				<h2 class="cafe-tarjeta__titulo"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php if ( $origen ) : ?>
					<p class="cafe-tarjeta__origen"><?php echo esc_html( $origen ); ?></p>
				<?php endif; ?>
				<?php if ( is_numeric( $precio ) ) : ?>
					<p class="cafe-tarjeta__precio"><?php echo esc_html( number_format_i18n( (float) $precio, 2 ) ); ?> € / 250 g</p>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
	</div>
	<?php the_posts_pagination(); ?>
<?php else : ?>
	<p>Todavía no hay cafés publicados.</p>
<?php endif; ?>

<?php get_footer(); ?>