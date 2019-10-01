<?php
/**
 * azeria Theme Customizer
 *
 * @package azeria
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function azeria_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'azeria_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function azeria_customize_preview_js() {
	wp_enqueue_script( 'azeria_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'azeria_customize_preview_js' );

/**
 * Adds Azeria-related customizer elements
 *
 * WordPress 3.4 Required
 */
add_action( 'customize_register', 'azeria_add_customizer' );

if( ! function_exists( 'azeria_add_customizer' ) ) {

	function azeria_add_customizer( $wp_customize ) {

		/* General section
		---------------------------------------------------------*/
		$wp_customize->add_section( 'azeria_general' , array(
			'title'      => __('General','azeria'),
			'priority'   => 35,
		) );

		/* Sticky menu */
		$wp_customize->add_setting( 'azeria[sticky_menu]', array(
				'default'           => 'static',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_select'
		) );
		$wp_customize->add_control( 'azeria_sticky_menu', array(
				'label'    => __( 'Menu type', 'azeria' ),
				'section'  => 'azeria_general',
				'settings' => 'azeria[sticky_menu]',
				'type'     => 'select',
				'priority' => 2,
				'choices'  => array(
						'static' => __( 'Static menu', 'azeria' ),
						'sticky' => __( 'Sticky menu', 'azeria' )
					)
		) );

		/* Header Logo section
		---------------------------------------------------------*/
		$wp_customize->add_section( 'azeria_header_logo' , array(
			'title'      => __('Header Logo','azeria'),
			'priority'   => 40,
		) );

		/* Logo image */
		$wp_customize->add_setting( 'azeria[logo_img]', array(
				'default'           => '',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_image'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'azeria_logo_img', array(
			'label'    => __( 'Logo Image', 'azeria' ),
			'section'  => 'azeria_header_logo',
			'settings' => 'azeria[logo_img]',
			'priority' => 1
		) ) );



		/* Slider section
		----------------------------------------------------*/
		$wp_customize->add_section( 'azeria_slider' , array(
			'title'      => __('Slider','azeria'),
			'priority'   => 61,
		) );

		/* Enable slider */
		$wp_customize->add_setting( 'azeria[slider_enabled]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_slider_enabled', array(
				'label'    => __( 'Enable/disable slider', 'azeria' ),
				'section'  => 'azeria_slider',
				'settings' => 'azeria[slider_enabled]',
				'type'     => 'checkbox',
				'priority' => 1
		) );

		/* Slider visibility */
		$wp_customize->add_setting( 'azeria[slider_visibility]', array(
				'default'           => 'front',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_select'
		) );
		$wp_customize->add_control( 'azeria_slider_visibility', array(
				'label'    => __( 'Slider visibility', 'azeria' ),
				'section'  => 'azeria_slider',
				'settings' => 'azeria[slider_visibility]',
				'type'     => 'select',
				'priority' => 2,
				'choices'  => array(
						'front' => __( 'Only on Front page', 'azeria' ),
						'all'   => __( 'On all pages', 'azeria' )
					)
		) );

		/* Get slides from */
		$wp_customize->add_setting( 'azeria[slides_from]', array(
				'default'           => 'recent_posts',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_select'
		) );
		$wp_customize->add_control( 'azeria_slides_from', array(
				'label'    => __( 'Get slides from', 'azeria' ),
				'section'  => 'azeria_slider',
				'settings' => 'azeria[slides_from]',
				'type'     => 'select',
				'priority' => 2,
				'choices'  => apply_filters(
					'azeria_slides_from_choices',
					array(
						'recent_posts' => __( 'Recent Posts (Default)', 'azeria' ),
						'sticky'       => __( 'Sticky Posts (Recommended)', 'azeria' ),
						'category'     => __( 'Specific Category', 'azeria' )
					)
				)
		) );

		/* Category to get from */
		$wp_customize->add_setting( 'azeria[slides_cat]', array(
				'default'           => '',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'azeria_slides_cat', array(
				'label'       => __( 'Category slug to get slides from (only if Specific Category selected)', 'azeria' ),
				'section'     => 'azeria_slider',
				'settings'    => 'azeria[slides_cat]',
				'type'        => 'text',
				'priority'    => 3
		) );

		/* Slides number */
		$wp_customize->add_setting( 'azeria[slides_num]', array(
				'default'           => 4,
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_num'
		) );
		$wp_customize->add_control( 'azeria_slides_num', array(
				'label'       => __( 'Slides number to show', 'azeria' ),
				'section'     => 'azeria_slider',
				'settings'    => 'azeria[slides_num]',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 20,
					'step' => 1,
				),
				'priority'    => 4
		) );

		/* Show/hide slides banners */
		$wp_customize->add_setting( 'azeria[slider_banner]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_slider_banner', array(
				'label'    => __( 'Show/hide slider banner', 'azeria' ),
				'section'  => 'azeria_slider',
				'settings' => 'azeria[slider_banner]',
				'type'     => 'checkbox',
				'priority' => 5
		) );

		/* Banner button text */
		$wp_customize->add_setting( 'azeria[slider_btn_text]', array(
				'default'           => __( 'Read', 'azeria' ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'azeria_slider_btn_text', array(
				'label'       => __( 'Banner read more button text', 'azeria' ),
				'section'     => 'azeria_slider',
				'settings'    => 'azeria[slider_btn_text]',
				'type'        => 'text',
				'priority'    => 6
		) );

		/* Show arrows */
		$wp_customize->add_setting( 'azeria[slider_arrows]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_slider_arrows', array(
				'label'    => __( 'Show/hide control arrows', 'azeria' ),
				'section'  => 'azeria_slider',
				'settings' => 'azeria[slider_arrows]',
				'type'     => 'checkbox',
				'priority' => 7
		) );

		/* Show pager */
		$wp_customize->add_setting( 'azeria[slider_pager]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_slider_pager', array(
				'label'    => __( 'Show/hide pager control', 'azeria' ),
				'section'  => 'azeria_slider',
				'settings' => 'azeria[slider_pager]',
				'type'     => 'checkbox',
				'priority' => 8
		) );

		/* Animation type */
		$wp_customize->add_setting( 'azeria[slider_animation]', array(
				'default'           => 'slide',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_select'
		) );
		$wp_customize->add_control( 'azeria_slider_animation', array(
				'label'    => __( 'Select animation type', 'azeria' ),
				'section'  => 'azeria_slider',
				'settings' => 'azeria[slider_animation]',
				'type'     => 'select',
				'priority' => 9,
				'choices'  => array(
					'slide' => __( 'Slide', 'azeria' ),
					'fade'  => __( 'Fade', 'azeria' )
				)
		) );

		/* Blog section
		----------------------------------------------------*/
		$wp_customize->add_section( 'azeria_blog' , array(
			'title'      => __('Blog','azeria'),
			'priority'   => 62,
		) );

		/* Blog content */
		$wp_customize->add_setting( 'azeria[blog_content]', array(
				'default'           => 'excerpt',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_select'
		) );
		$wp_customize->add_control( 'azeria_blog_content', array(
				'label'    => __( 'Blog content shows:', 'azeria' ),
				'section'  => 'azeria_blog',
				'settings' => 'azeria[blog_content]',
				'type'     => 'select',
				'priority' => 1,
				'choices'  => array(
					'excerpt' => __( 'Only excerpt', 'azeria' ),
					'content' => __( 'Full content', 'azeria' )
				)
		) );

		/* Loop featured image */
		$wp_customize->add_setting( 'azeria[blog_loop_image]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_blog_loop_image', array(
				'label'    => __( 'Loop page: show featured image', 'azeria' ),
				'section'  => 'azeria_blog',
				'settings' => 'azeria[blog_loop_image]',
				'type'     => 'checkbox',
				'priority' => 2
		) );

		/* Single featured image */
		$wp_customize->add_setting( 'azeria[blog_single_image]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_blog_single_image', array(
				'label'    => __( 'Single page: show featured image', 'azeria' ),
				'section'  => 'azeria_blog',
				'settings' => 'azeria[blog_single_image]',
				'type'     => 'checkbox',
				'priority' => 3
		) );

		/* Loop show button */
		$wp_customize->add_setting( 'azeria[blog_more]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_blog_more', array(
				'label'    => __( 'Loop page: show read more button', 'azeria' ),
				'section'  => 'azeria_blog',
				'settings' => 'azeria[blog_more]',
				'type'     => 'checkbox',
				'priority' => 4
		) );

		/* Read button text */
		$wp_customize->add_setting( 'azeria[blog_more_text]', array(
				'default'           => __( 'Read', 'azeria' ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'azeria_blog_more_text', array(
				'label'       => __( 'Loop page: read more button text', 'azeria' ),
				'section'     => 'azeria_blog',
				'settings'    => 'azeria[blog_more_text]',
				'type'        => 'text',
				'priority'    => 5
		) );

		/* Sidebar position */
		$wp_customize->add_setting( 'azeria[sidebar_position]', array(
				'default'           => 'right',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_select'
		) );
		$wp_customize->add_control( 'azeria_sidebar_position', array(
				'label'    => __( 'Sidebar position', 'azeria' ),
				'section'  => 'azeria_blog',
				'settings' => 'azeria[sidebar_position]',
				'type'     => 'select',
				'priority' => 6,
				'choices'  => array(
					'right' => __( 'Right', 'azeria' ),
					'left'  => __( 'Left', 'azeria' )
				)
		) );

		/* Footer section
		----------------------------------------------------*/
		$wp_customize->add_section( 'azeria_footer' , array(
			'title'      => __('Footer','azeria'),
			'priority'   => 63,
		) );

		/* Custom copyright */
		$wp_customize->add_setting( 'azeria[footer_copyright]', array(
				'default'           => '',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'esc_textarea'
		) );
		$wp_customize->add_control( 'azeria_footer_copyright', array(
				'label'       => __( 'Set custom copyright text', 'azeria' ),
				'section'     => 'azeria_footer',
				'settings'    => 'azeria[footer_copyright]',
				'type'        => 'textarea',
				'priority'    => 1
		) );

		/* About section
		----------------------------------------------------*/
		$wp_customize->add_section( 'azeria_about' , array(
			'title'      => __('About box','azeria'),
			'priority'   => 81,
		) );

		/* Enable about */
		$wp_customize->add_setting( 'azeria[about_enabled]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_about_enabled', array(
				'label'    => __( 'Enable About box in sidebar', 'azeria' ),
				'section'  => 'azeria_about',
				'settings' => 'azeria[about_enabled]',
				'type'     => 'checkbox',
				'priority' => 1
		) );

		/* About title */
		$wp_customize->add_setting( 'azeria[about_title]', array(
				'default'           => __( 'About Me', 'azeria' ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'azeria_about_title', array(
				'label'       => __( 'Enter sidebar about box title', 'azeria' ),
				'section'     => 'azeria_about',
				'settings'    => 'azeria[about_title]',
				'type'        => 'text',
				'priority'    => 2
		) );

		/* About image */
		$wp_customize->add_setting( 'azeria[about_img]', array(
				'default'           => '',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_image'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'azeria_about_img', array(
			'label'    => __( 'About Image', 'azeria' ),
			'section'  => 'azeria_about',
			'settings' => 'azeria[about_img]',
			'priority' => 3
		) ) );

		/* About message */
		$wp_customize->add_setting( 'azeria[about_message]', array(
				'default'           => __( 'Hello! And welcome to my personal website!', 'azeria' ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'esc_textarea'
		) );
		$wp_customize->add_control( 'azeria_about_message', array(
				'label'       => __( 'Set about box message text', 'azeria' ),
				'section'     => 'azeria_about',
				'settings'    => 'azeria[about_message]',
				'type'        => 'textarea',
				'priority'    => 4
		) );

		/* Follow section
		----------------------------------------------------*/
		$wp_customize->add_section( 'azeria_follow' , array(
			'title'      => __('Follow box','azeria'),
			'priority'   => 82,
		) );

		/* Enable follow */
		$wp_customize->add_setting( 'azeria[follow_enabled]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'azeria_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'azeria_follow_enabled', array(
				'label'    => __( 'Enable Follow box in sidebar', 'azeria' ),
				'section'  => 'azeria_follow',
				'settings' => 'azeria[follow_enabled]',
				'type'     => 'checkbox',
				'priority' => 1
		) );

		/* Follow title */
		$wp_customize->add_setting( 'azeria[follow_title]', array(
				'default'           => __( 'Follow Me', 'azeria' ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'azeria_follow_title', array(
				'label'       => __( 'Enter follow about box title', 'azeria' ),
				'section'     => 'azeria_follow',
				'settings'    => 'azeria[follow_title]',
				'type'        => 'text',
				'priority'    => 2
		) );

		/* Social links */
		$socials = azeria_allowed_socials();

		// prevent error from wrong filters applied
		if ( is_array( $socials ) ) {
			// add allowed nets to customizer
			foreach ( $socials as $net => $data ) {

				$data = wp_parse_args( $data, array( 'label' => '', 'icon' => '', 'default' => '' ) );

				$wp_customize->add_setting( 'azeria[follow_' . $net . ']', array(
						'default'           => $data['default'],
						'type'              => 'theme_mod',
						'sanitize_callback' => 'azeria_sanitize_url'
				) );
				$wp_customize->add_control( 'azeria_follow_' . $net, array(
						'label'       => sprintf( __( 'Link to %s account:', 'azeria' ), $data['label'] ),
						'section'     => 'azeria_follow',
						'settings'    => 'azeria[follow_' . $net . ']',
						'type'        => 'text',
						'priority'    => 3
				) );

			}
		}

	}

}

/**
 * Sanitize URL function for customizer
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function azeria_sanitize_url( $url ) {
	return esc_url_raw( $url );
}

/**
 * Sanitize image URL
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function azeria_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Sanitize checkbox for customizer
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function azeria_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitize callback select input
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function azeria_sanitize_select( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	$control = str_replace( '[', '_', trim( $setting->id, ']' ) );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $control )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize numeric value
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function azeria_sanitize_num( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );

	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}