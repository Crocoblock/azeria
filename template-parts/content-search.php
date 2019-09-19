<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package azeria
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'is-loop' ); ?>>
	
	<header class="entry-header">
		<?php 
			$format = get_post_format();
			
			if ( ! $format ) {
				$format = 'standard';
			}

			azeria_format_icon( $format ); 
		?>
		<div class="entry-header-data">
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php azeria_post_meta(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php azeria_blog_content(); ?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php 
			azeria_post_meta( 'loop', 'footer' );
			azeria_read_more();
		?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

