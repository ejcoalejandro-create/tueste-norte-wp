<?php
/**
 * Entrada individual. Los cafés usan su propia ficha.
 */
get_header();

while ( have_posts() ) :
	the_post();

	if ( in_category( 'cafes' ) ) {
		get_template_part( 'template-parts/content/content-cafe' );
	} else {
		get_template_part( 'template-parts/content/content-single' );
	}

	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;

get_footer();