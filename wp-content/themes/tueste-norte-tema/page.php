<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class( 'pagina' ); ?>>
		<h1 class="titulo-pagina"><?php the_title(); ?></h1>
		<div class="texto"><?php the_content(); ?></div>
	</article>
<?php endwhile; ?>

<?php get_footer(); ?>