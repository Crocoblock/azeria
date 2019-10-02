<?php
/**
 * Template part for displaying archive pages.
 *
 * @package azeria
 */
?>

<div class="container">
	<div class="row">
		<main id="main" class="site-main col-md-8 col-sm-12 col-xs-12 <?php azeria_sidebar_class(); ?>" role="main">
			<?php if ( have_posts() ) : ?>

				<?php if ( is_archive() ) : ?>
					<header class="page-header">
						<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header><!-- .page-header -->
				<?php endif; ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php
				the_posts_pagination(
					array(
						'prev_text' => azeria_get_icon_svg( 'arrow-double-left' ),
						'next_text' => azeria_get_icon_svg( 'arrow-double-right' ),
					)
				);
				?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #main -->
		<?php get_sidebar(); ?>
	</div>
</div>
