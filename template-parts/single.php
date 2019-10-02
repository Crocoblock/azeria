<?php
/**
 * Template part for displaying all single posts.
 *
 * @package azeria
 */
?>
<div class="container">
	<div class="row">
		<main id="main" class="site-main col-md-8 col-sm-12 col-xs-12 <?php azeria_sidebar_class(); ?>" role="main">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'single' ); ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
		<?php get_sidebar(); ?>
	</div>
</div>
