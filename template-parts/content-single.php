<?php
/**
 * Template part for displaying single posts.
 *
 * @package azeria
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'is-single' ); ?>>
	<?php azeria_post_thumbnail( false ); ?>
	<header class="entry-header">

		<?php
			$format = get_post_format();

			if ( ! $format ) {
				$format = 'standard';
			}

			azeria_format_icon( $format );
		?>
		<div class="entry-header-data">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<div class="entry-meta">
				<?php azeria_post_meta( 'single' ); ?>
			</div><!-- .entry-meta -->
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'azeria' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php azeria_post_meta( 'single', 'footer' ); ?>
		<?php
			$prev_icon = azeria_get_icon_svg( 'arrow-left' );
			$next_icon = azeria_get_icon_svg( 'arrow-right' );

			the_post_navigation(
				array(
					'prev_text' => '<span class="post-nav-label button">' . $prev_icon . __( 'Prev', 'azeria' ) . '</span><span class="post-nav-title">%title</span>',
					'next_text' => '<span class="post-nav-label button">' . __( 'Next', 'azeria' ) . $next_icon . '</span><span class="post-nav-title">%title</span>'
				)
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

<?php do_action( 'azeria_after_single_post_content' ); ?>