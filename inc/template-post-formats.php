<?php
/**
 * Post format specific template tags
 *
 * @package azeria
 */

/**
 * Show featured image for iamge post format.
 */
function azeria_post_image() {

	$post_id   = get_the_ID();
	$post_type = get_post_type( $post_id );

	$default_init = array(
		'type' => 'image'
	);

	$thumb_format = '<figure class="entry-image"><a href="%2$s" class="image-popup">%1$s<span class="link-marker popup"></span></a></figure>';

	/**
	 * Filter the arguments used to init image zoom popup.
	 */
	$init = apply_filters( 'azeria_post_image_popup_init', $default_init );
	$init = wp_parse_args( $init, $default_init );

	$init = json_encode( $init );

	// Check if post has featured image
	if ( has_post_thumbnail( $post_id ) ) {

		$thumb = get_the_post_thumbnail( $post_id, 'post-thumbnail', array( 'alt' => get_the_title( $post_id ) ) );
		$url   = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );

	} else {

		// if not featured image - try to get image from content
		$img = azeria_post_images();

		if ( ! $img || empty( $img ) || empty( $img[0] ) ) {

			return false;

		} elseif ( is_int( $img[0] ) ) {

			$thumb = wp_get_attachment_image( $img[0], 'post-thumbnail', '', array( 'alt' => get_the_title( $post_id ) ) );
			$url   = wp_get_attachment_url( $img[0] );

		} else {

			global $_wp_additional_image_sizes;

			if ( ! isset( $_wp_additional_image_sizes['post-thumbnail'] ) ) {
				return false;
			}

			$thumb = '<img src="' . esc_url( $img[0] ) . '" width="' . $_wp_additional_image_sizes['post-thumbnail']['width'] . '">';
			$url   = $img[0];

		}
	}

	printf( $thumb_format, $thumb, $url, $init );

}

/**
 * Show featured gallery for gallery post format
 */
function azeria_post_gallery() {

	$post_id = get_the_ID();

	// first - try to get images from galleries in post
	$post_gallery = get_post_gallery( $post_id, false );

	if ( ! empty( $post_gallery['ids'] ) ) {
		$post_gallery = explode( ',', $post_gallery['ids'] );
	} elseif ( ! empty( $post_gallery['src'] ) ) {
		$post_gallery = $post_gallery['src'];
	} else {
		$post_gallery = false;
	}

	// if can't try to catch images inserted into post
	if ( ! $post_gallery ) {
		$post_gallery = azeria_post_images( $post_id, 15 );
	}

	// and if not find any images - try to get images attached to post
	if ( ! $post_gallery || empty( $post_gallery ) ) {

		$attachments = get_children( array(
			'post_parent'    => $post_id,
			'posts_per_page' => 3,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );

		if ( $attachments && is_array( $attachments ) ) {
			$post_gallery = array_keys( $attachments );
		}
	}

	if ( ! $post_gallery || empty( $post_gallery ) ) {
		return false;
	}

	$output = azeria_get_gallery_html( $post_gallery, array( 'id' => $post_id ) );

	echo $output;
}

/**
 * Build default gallery HTML from images array.
 */
function azeria_get_gallery_html( $images, $atts = array() ) {

	$atts = wp_parse_args( $atts, array(
		'link' => ''
	) );

	$id = isset( $atts['id'] ) ? $atts['id'] : rand( 0, 999 );

	$default_slider_init = array(
		'infinite'       => true,
		'speed'          => 400,
		'fade'           => true,
		'cssEase'        => 'linear',
		'adaptiveHeight' => true,
		'dots'           => false,
		'prevArrow'      => '.entry-gallery-prev-' . $id,
		'nextArrow'      => '.entry-gallery-next-' . $id,
	);

	/**
	 * Filter default gallery slider inits.
	 */
	$init = apply_filters( 'azeria_post_gallery_slider_init', $default_slider_init );
	$init = wp_parse_args( $init, $default_slider_init );
	$init = json_encode( $init );

	$default_gall_init = array(
		'delegate' => '.popup-gallery-item',
		'type'     => 'image',
		'gallery'  => array(
			'enabled' => true
		)
	);

	/**
	 * Filter default gallery popup inits.
	 */
	$gall_init = apply_filters( 'azeria_post_gallery_popup_init', $default_gall_init );
	$gall_init = wp_parse_args( $gall_init, $default_gall_init );
	$gall_init = json_encode( $gall_init );

	$items   = array();
	$counter = 0;

	foreach ( $images as $img ) {

		$caption = '';

		if ( 0 === $counter ) {
			$nth_class = '';
			$counter++;
		} else {
			$nth_class = ' nth-child';
		}

		if ( 0 < intval( $img ) ) {
			$image = wp_get_attachment_image( $img, 'post-thumbnail', '' );
			$url   = wp_get_attachment_url( $img );

			$attachment = get_post( $img );

			if ( ! empty( $attachment->post_excerpt ) ) {
				$caption_class = 'entry-gallery-caption';
				$caption_text  = wptexturize( $attachment->post_excerpt );
				$caption       = '<figcaption class="' . $caption_class . '">' . $caption_text . '</figcaption>';
			}

		} else {

			global $_wp_additional_image_sizes;

			if ( ! isset( $_wp_additional_image_sizes['post-thumbnail'] ) ) {
				$width = 'auto';
			} else {
				$width = $_wp_additional_image_sizes['post-thumbnail']['width'];
			}

			$image = '<img src="' . esc_url( $img ) . '" width="' . $width . '">';
			$url   = $img;
		}

		if ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$format = '<figure class="%3$s">%1$s%4$s</figure>';
		} else {
			$format = '<figure class="%3$s"><a href="%2$s" class="%3$s_link popup-gallery-item">%1$s<span class="link-marker popup"></span></a>%4$s</figure>';
		}

		$items[] = sprintf(
			$format,
			$image, $url, 'entry-gallery-item ' . $nth_class, $caption
		);
	}

	$items = implode( "\r\n", $items );

	$prev_arrow = sprintf( '<span class="entry-gallery-prev entry-gallery-prev-%2$s" role="button">%1$s</span>', azeria_get_icon_svg( 'arrow-left' ), $id );
	$next_arrow = sprintf( '<span class="entry-gallery-next entry-gallery-next-%2$s" role="button">%1$s</span>', azeria_get_icon_svg( 'arrow-right' ), $id );

	$result = sprintf(
		'<div class="%2$s popup-gallery" data-init=\'%3$s\' data-popup-init=\'%4$s\'><div class="%2$s-items">%1$s</div>%5$s%6$s</div>',
		$items, 'entry-gallery', $init, $gall_init, $prev_arrow, $next_arrow
	);

	return $result;
}

/**
 * Get images from post content.
 * Returns image ID's if can find this image in database,
 * returns image URL or bollen false in other case.
 */
function azeria_post_images( $post_id = null, $limit = 1 ) {

	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$content = get_the_content();

	// Gets first image from content.
	preg_match_all( '/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $matches );

	if ( !isset( $matches[1] ) ) {
		return false;
	}

	$result = array();

	global $wpdb;

	for ( $i = 0; $i < $limit; $i++ ) {

		if ( empty( $matches[1][$i] ) ) {
			continue;
		}

		$image_src = esc_url( $matches[1][$i] );
		$image_src = preg_replace( '/^(.+)(-\d+x\d+)(\..+)$/', '$1$3', $image_src );

		// Try to get current image ID.
		$query = "SELECT ID FROM $wpdb->posts WHERE guid=%s";
		$id    = $wpdb->get_var( $wpdb->prepare( $query, $image_src ) );

		if ( ! $id ) {
			$result[] = $image_src;
		} else {
			$result[] = (int)$id;
		}

	}

	return $result;
}

/**
 * Show first found video, iframe, object or embed tag in content.
 */
function azeria_post_video() {

	$content = apply_filters( 'the_content', get_the_content() );
	$types   = array( 'video', 'object', 'embed', 'iframe' );
	$embeds  = get_media_embedded_in_content( $content, $types );

	if ( empty( $embeds ) ) {
		return;
	}

	foreach ( $types as $tag ) {
		if ( preg_match( "/<{$tag}[^>]*>(.*?)<\/{$tag}>/", $embeds[0], $matches ) ) {
			$result = $matches[0];
			break;
		}
	}

	if ( false === $result ) {
		return;
	}

	printf( '<div class="entry-video embed-responsive embed-responsive-16by9">%s</div>', $result );
	
}