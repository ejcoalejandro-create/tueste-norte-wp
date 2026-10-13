<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class( 'pagina' ); ?>>
		<h1 class="titulo-pagina"><?php the_title(); ?></h1>
		<p class="meta"><?php echo esc_html( get_the_date() ); ?></p>
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large' ); ?>
		<?php endif; ?>
		<div class="texto"><?php the_content(); ?></div>
	</article>
<?php endwhile; ?>

<?php get_footer(); ?>