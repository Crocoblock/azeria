<?php
/**
 * Template part for displaying search results pages.
 *
 * @package azeria
 */
?>
<div class="container">
	<div class="row">
		<main id="main" class="site-main col-md-8 col-sm-12 col-xs-12 <?php azeria_sidebar_class(); ?>" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'azeria' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );
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
