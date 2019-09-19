<?php
/**
 * Template part for displaying posts.
 *
 * @package azeria
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'is-loop' ); ?>>
	
	<header class="entry-header">
		<?php azeria_format_icon( 'gallery' ); ?>
		<div class="entry-header-data">
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php azeria_post_meta(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</div>
	</header><!-- .entry-header -->
	<?php azeria_post_gallery(); ?>
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
