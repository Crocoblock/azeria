<?php
/**
 * Template Name: Full Width Page
 *
 * @package azeria
 */

get_header(); ?>

	<div class="container">
		<div class="row">
			<main id="main" class="site-main col-md-12 col-sm-12 col-xs-12" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // End of the loop. ?>

			</main><!-- #main -->
		</div>
	</div>
<?php get_footer(); ?>
