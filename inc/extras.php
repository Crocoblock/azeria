<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package azeria
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function azeria_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'azeria_body_classes' );


/**
 * Get allowed socials data (to add options into customizer and output on front)
 */
function azeria_allowed_socials() {

	return apply_filters(
		'azeria_allowed_socials',
		array(
			'facebook' => array(
				'label'   => __( 'Facebook', 'azeria' ),
				'icon'    => 'fa fa-facebook',
				'default' => 'https://www.facebook.com/'
			),
			'twitter' => array(
				'label'   => __( 'Twitter', 'azeria' ),
				'icon'    => 'fa fa-twitter',
				'default' => 'https://twitter.com/'
			),
			'google-plus' => array(
				'label'   => __( 'Google +', 'azeria' ),
				'icon'    => 'fa fa-google-plus',
				'default' => 'https://plus.google.com/'
			),
			'instagram' => array(
				'label'   => __( 'Instagram', 'azeria' ),
				'icon'    => 'fa fa-instagram',
				'default' => 'https://instagram.com/'
			),
			'pinterest' => array(
				'label'   => __( 'Pinterest', 'azeria' ),
				'icon'    => 'fa fa-pinterest',
				'default' => 'https://www.pinterest.com/'
			),
			'dribbble' => array(
				'label'   => __( 'Dribbble', 'azeria' ),
				'icon'    => 'fa fa-dribbble',
				'default' => 'https://dribbble.com/'
			)
		)
	);

}

/**
 * Custom comment output
 */
function azeria_comment( $comment, $args, $depth ) {

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'azeria' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'azeria' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-author-thumb">
				<?php echo get_avatar( $comment, 50 ); ?>
			</div><!-- .comment-author -->
			<div class="comment-content">
				<div class="comment-meta">
					<?php printf( '<div class="comment-author">%s</div>', get_comment_author_link() ); ?>
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ' . __( 'ago', 'azeria' ); ?>
					</time>
					<?php
						comment_reply_link( 
							array_merge( $args, array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '<div class="reply">',
								'after'     => '</div>',
							) ),
							$comment
						);
					?>
				</div>
				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'azeria' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
		</article><!-- .comment-body -->

	<?php
	endif;

}