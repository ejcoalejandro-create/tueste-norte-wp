<?php get_header(); ?>

<?php if ( is_home() && ! is_front_page() ) : ?>
	<h1 class="titulo-pagina"><?php single_post_title(); ?></h1>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'entrada' ); ?>>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="meta"><?php echo esc_html( get_the_date() ); ?></p>
			<?php the_excerpt(); ?>
		</article>
	<?php endwhile; ?>
	<?php the_posts_pagination(); ?>
<?php else : ?>
	<p>Todavía no hay nada por aquí.</p>
<?php endif; ?>

<?php get_footer(); ?>