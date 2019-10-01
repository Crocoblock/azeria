<?php
/**
 * Template part for displaying posts.
 *
 * @package azeria
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'is-loop' ); ?>>
	
	<div class="entry-content">
		<?php echo azeria_get_icon_svg( 'post-quote', 'quote-icon' ); ?>
		<?php azeria_blog_content(); ?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php 
			azeria_post_meta( 'loop', 'footer' );
			azeria_read_more();
		?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
