<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package azeria
 */

/**
 * Show post author
 */
function azeria_post_author() {
	$author = sprintf(
		'<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	echo '<span class="entry-meta-item author"><i class="fa fa-user"></i> ' . $author . '</span>';
}

/**
 * Prints HTML with meta information for the current post-date.
 */
function azeria_post_date() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="entry-meta-item posted-on"><i class="fa fa-clock-o"></i> ' . $posted_on . '</span>'; // WPCS: XSS OK.

}

/**
 * Prints HTML with meta information for the current post-date.
 */
function azeria_post_comments() {

	if ( post_password_required() || ! comments_open() ) {
		return;
	}

	echo '<span class="entry-meta-item comments"><i class="fa fa-pencil-square-o"></i> ';
	comments_popup_link( esc_html__( 'Leave a comment', 'azeria' ), esc_html__( '1 Comment', 'azeria' ), esc_html__( '% Comments', 'azeria' ) );
	echo '</span>';

}

function azeria_post_categories() {

	// Hide category and tag text for pages.
	if ( 'post' != get_post_type() ) {
		return;
	}

	$categories_list = get_the_category_list( esc_html__( ', ', 'azeria' ) );
	if ( $categories_list && azeria_categorized_blog() ) {
		printf( '<span class="entry-meta-item cat-links"><i class="fa fa-folder-open"></i> ' . esc_html__( 'Posted in %1$s', 'azeria' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}

}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function azeria_post_tags() {
	// Hide category and tag text for pages.
	if ( 'post' != get_post_type() ) {
		return;
	}

	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'azeria' ) );
	if ( $tags_list ) {
		printf( '<span class="entry-meta-item tags-links"><i class="fa fa-tags"></i> ' . esc_html__( 'Tagged %1$s', 'azeria' ) . '</span>', $tags_list ); // WPCS: XSS OK.
	}

}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function azeria_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'azeria_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'azeria_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so azeria_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so azeria_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in azeria_categorized_blog.
 */
function azeria_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'azeria_categories' );
}
add_action( 'edit_category', 'azeria_category_transient_flusher' );
add_action( 'save_post',     'azeria_category_transient_flusher' );

/**
 * Show site logo markup depending from site options
 */
function azeria_logo() {

	$logo_img = azeria_get_option( 'logo_img' );

	$logo_tag = 'h2';

	if ( is_front_page() ) {
		$logo_tag = 'h1';
	}

	if ( false != $logo_img ) {
		$logo_content = '<img src="' . esc_url( $logo_img ) . '" alt="' . get_bloginfo( 'name' ) . '">';
	} else {
		$logo_content = get_bloginfo( 'name' );
	}

	printf( '<%1$s class="site-logo"><a class="site-logo-link" href="%2$s">%3$s</a></%1$s>', $logo_tag, esc_url( home_url( '/' ) ), $logo_content );

}

/**
 * Show posts listing content depending from options
 */
function azeria_blog_content() {

	$blog_content = azeria_get_option( 'blog_content', 'excerpt' );

	if ( 'excerpt' == $blog_content ) {
		the_excerpt();
		return;
	}

	/* translators: %s: Name of current post */
	the_content( sprintf(
		wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'azeria' ), array( 'span' => array( 'class' => array() ) ) ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
	) );

	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'azeria' ),
		'after'  => '</div>',
	) );

}

/**
 * Show format-related icon
 */
function azeria_format_icon( $format = 'standard' ) {

	$formats = array(
		'sticky'   => 'star',
		'standard' => 'pencil',
		'aside'    => 'map-marker',
		'image'    => 'picture-o',
		'gallery'  => 'picture-o',
		'video'    => 'video-camera',
		'quote'    => 'quote-left',
		'link'     => 'link'
	);

	if ( ! array_key_exists( $format, $formats ) ) {
		return '';
	}

	if ( is_sticky() ) {
		$format = 'sticky';
	}

	printf( '<div class="entry-icon"><i class="fa fa-%s"></i></div>', $formats[$format] );

}

/**
 * Show post meta data
 *
 * @param string $page     page, meta called from
 * @param string $position position, meta called from
 * @param string $disable  disabled meta keys array
 */
function azeria_post_meta( $page = 'loop', $position = 'header', $disable = array() ) {

	$default_meta = array(
		'author' => array(
			'page'     => $page,
			'position' => 'header',
			'callback' => 'azeria_post_author',
			'priority' => 1
		),
		'date' => array(
			'page'     => $page,
			'position' => 'header',
			'callback' => 'azeria_post_date',
			'priority' => 5
		),
		'comments' => array(
			'page'     => $page,
			'position' => 'header',
			'callback' => 'azeria_post_comments',
			'priority' => 5
		),
		'categories' => array(
			'page'     => 'single',
			'position' => 'footer',
			'callback' => 'azeria_post_categories',
			'priority' => 1
		),
		'tags' => array(
			'page'     => 'single',
			'position' => 'footer',
			'callback' => 'azeria_post_tags',
			'priority' => 5
		)
	);

	/**
	 * Get 3rd party meta items to show in meta block (or disable default from child theme)
	 */
	$meta_items = apply_filters( 'azeria_meta_items_data', $default_meta, $page, $position );
	$disable    = apply_filters( 'azeria_disabled_meta', $disable );

	foreach ( $meta_items as $meta_key => $data ) {

		if ( is_array( $disable ) && in_array( $meta_key, $disable ) ) {
			continue;
		}
		if ( empty( $data['page'] ) || $page != $data['page'] ) {
			continue;
		}
		if ( empty( $data['position'] ) || $position != $data['position'] ) {
			continue;
		}
		if ( empty( $data['callback'] ) || ! function_exists( $data['callback'] ) ) {
			continue;
		}

		$priority = ( ! empty( $data['priority'] ) ) ? absint( $data['priority'] ) : 10;

		add_action( 'azeria_post_meta_' . $page . '_' . $position, $data['callback'], $priority );
	}

	do_action( 'azeria_post_meta_' . $page . '_' . $position );

}

/**
 * Show post featured image
 * @param  boolean $is_linked liked image or not
 */
function azeria_post_thumbnail( $is_linked = true ) {

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$is_enabled = true;

	if ( is_single() ) {
		$is_enabled = azeria_get_option( 'blog_single_image', true );
	} else {
		$is_enabled = azeria_get_option( 'blog_loop_image', true );
	}

	$is_enabled = (bool)$is_enabled;

	if ( ! $is_enabled ) {
		return;
	}

	if ( $is_linked ) {
		$format = '<figure class="entry-thumbnail"><a href="%2$s">%1$s<span class="link-marker"></span></a></figure>';
		$link   = get_permalink();
	} else {
		$format = '<figure class="entry-thumbnail">%1$s</figure>';
		$link   = false;
	}

	$image = get_the_post_thumbnail( get_the_id(), 'post-thumbnail', array( 'alt' => get_the_title() ) );

	printf( $format, $image, $link );

}

/**
 * Show read more button if enabled
 */
function azeria_read_more() {

	if ( post_password_required() ) {
		return;
	}

	$is_enabled = azeria_get_option( 'blog_more', true );

	if ( ! $is_enabled ) {
		return;
	}

	$text = azeria_get_option( 'blog_more_text', __( 'Read', 'azeria' ) );

	printf( '<div class="etry-more-btn"><a href="%1$s" class="button">%2$s</a></div>', get_permalink(), esc_textarea( $text ) );

}

/**
 * Print options-related class to determine sidebar position
 */
function azeria_sidebar_class() {
	$sidebar_position = azeria_get_option( 'sidebar_position', 'right' );
	printf( '%s-sidebar', esc_attr( $sidebar_position ) );
}

/**
 * Show 'to top' button HTML markup
 */
function azeria_to_top() {

	echo apply_filters(
		'azeria_to_top_button',
		'<div id="back-top" class="back-top-btn"><a href="#"><i class="fa fa-angle-up"></i></a></div>'
	);

}