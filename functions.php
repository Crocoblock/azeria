<?php
/**
 * azeria functions and definitions
 *
 * @package azeria
 */

if ( ! isset( $content_width ) ) {
	$content_width = 650;
}

if ( ! function_exists( 'azeria_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function azeria_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on azeria, use a find and replace
	 * to change 'azeria' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'azeria', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	// Add editor styling
	add_editor_style( 'editor-style.css' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Allow to rewrite defined image sizes from child theme
	 */
	$default_image_sizes = array(
		'post-thumbnail' => array(
			'width'  => 730,
			'height' => 360,
			'crop'   => true
		),
		'slider-thumbnail' => array(
			'width'  => 1900,
			'height' => 445,
			'crop'   => true
		),
		'related-thumbnail' => array(
			'width'  => 210,
			'height' => 180,
			'crop'   => true
		)
	);

	$image_sizes = wp_parse_args(
		apply_filters( 'azeria_image_sizes', $default_image_sizes ),
		$default_image_sizes
	);

	// default post thumbnail size
	set_post_thumbnail_size(
		$image_sizes['post-thumbnail']['width'],
		$image_sizes['post-thumbnail']['height'],
		$image_sizes['post-thumbnail']['crop']
	);

	// single slide thumbnail
	add_image_size( 'azeria-slider-thumbnail',
		$image_sizes['slider-thumbnail']['width'],
		$image_sizes['slider-thumbnail']['height'],
		$image_sizes['slider-thumbnail']['crop']
	);

	// related post thumbnail
	add_image_size( 'azeria-related-thumbnail',
		$image_sizes['related-thumbnail']['width'],
		$image_sizes['related-thumbnail']['height'],
		$image_sizes['related-thumbnail']['crop']
	);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'azeria' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'image',
		'gallery',
		'video',
		'quote',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'azeria_custom_background_args', array(
		'default-color' => 'f3f3f3',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'style-editor.css' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );
}
endif; // azeria_setup
add_action( 'after_setup_theme', 'azeria_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function azeria_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'azeria' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Left', 'azeria' ),
		'id'            => 'footer-sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Midlle', 'azeria' ),
		'id'            => 'footer-sidebar-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Right', 'azeria' ),
		'id'            => 'footer-sidebar-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'azeria_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function azeria_assets() {

	$template      = get_template();
	$theme_obj     = wp_get_theme( $template );
	$theme_version = $theme_obj->get( 'Version' );

	$base_url = get_template_directory_uri();

	// Styles
	wp_enqueue_style( 'azeria-fonts', azeria_fonts_url() );
	wp_enqueue_style( 'azeria-style', get_stylesheet_uri(), false, $theme_version );

	// Scripts
	wp_enqueue_script( 'jquery-slick', $base_url . '/js/slick.min.js', array( 'jquery' ), '1.8.1', true );
	wp_enqueue_script( 'jquery-magnific-popup', $base_url . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	wp_enqueue_script( 'azeria-navigation', $base_url . '/js/navigation.js', array( 'jquery', 'hoverIntent' ), $theme_version, true );
	wp_enqueue_script( 'azeria-skip-link-focus-fix', $base_url . '/js/skip-link-focus-fix.js', array(), $theme_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$menu_type = azeria_get_option( 'sticky_menu', 'static' );

	if ( 'sticky' === $menu_type ) {
		wp_enqueue_script( 'azeria-stickup', $base_url . '/js/jquery.stickup.js', array( 'jquery' ), '1.1.0', true );
	}

	wp_enqueue_script( 'azeria-custom-script', $base_url . '/js/script.js', array( 'jquery' ), $theme_version, true );
}
add_action( 'wp_enqueue_scripts', 'azeria_assets' );

/**
 * Get necessary Google fonts URL
 */
function azeria_fonts_url() {

	$fonts_url = '';

	$locale = get_locale();
	$cyrillic_locales = array( 'ru_RU', 'mk_MK', 'ky_KY', 'bg_BG', 'sr_RS', 'uk', 'bel' );

	/* Translators: If there are characters in your language that are not
	 * supported by Montserrat Alternates, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$montserrat = _x( 'on', 'Montserrat Alternates font: on or off', 'azeria' );

	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans Condensed, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$open_sans_condensed = _x( 'on', 'Open Sans Condensed font: on or off', 'azeria' );

	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'azeria' );

	if ( 'off' == $montserrat && 'off' == $open_sans_condensed && 'off' == $open_sans ) {
		return $fonts_url;
	}

	$font_families = array();

	if ( 'off' !== $montserrat ) {
		$font_families[] = 'Montserrat Alternates';
	}

	if ( 'off' !== $open_sans_condensed ) {
		$font_families[] = 'Open Sans Condensed:300,700,300italic';
	}

	if ( 'off' !== $open_sans ) {
		$font_families[] = 'Open Sans:300,400,700,400italic,700italic';
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	if ( in_array($locale, $cyrillic_locales) ) {
		$query_args['subset'] = urlencode( 'latin,latin-ext,cyrillic' );
	}

	$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

	return $fonts_url;
}

/**
 * Get theme option by name
 *
 * @param  string $name    option name
 * @param  mixed  $default default option value
 */
function azeria_get_option( $name, $default = false ) {

	$all_options = get_theme_mod( 'azeria' );

	if ( is_array( $all_options ) && isset( $all_options[$name] ) ) {
		return $all_options[$name];
	}

	return $default;

}

/**
 * Do Elementor or Jet Theme Core location
 *
 * @since  1.2.0
 * @param  string $location
 * @param  string $fallback
 * @return bool
 */
function azeria_do_location( $location = null, $fallback = null ) {

	$handler = false;
	$done    = false;

	// Choose handler
	if ( function_exists( 'jet_theme_core' ) ) {
		$handler = array( jet_theme_core()->locations, 'do_location' );
	} elseif ( function_exists( 'elementor_theme_do_location' ) ) {
		$handler = 'elementor_theme_do_location';
	}

	// If handler is found - try to do passed location
	if ( false !== $handler ) {
		$done = call_user_func( $handler, $location );
	}

	if ( true === $done ) {
		// If location successfully done - return true
		return true;
	} elseif ( null !== $fallback ) {
		// If for some reasons location couldn't be done and passed fallback template name - include this template and return
		if ( is_array( $fallback ) ) {
			// fallback in name slug format
			get_template_part( $fallback[0], $fallback[1] );
		} else {
			// fallback with just a name
			get_template_part( $fallback );
		}
		return true;
	}

	// In other cases - return false
	return false;
}

/**
 * Register Elementor Pro locations
 *
 * @param object $elementor_theme_manager
 */
function azeria_elementor_locations( $elementor_theme_manager ) {

	// Do nothing if Jet Theme Core is active.
	if ( function_exists( 'jet_theme_core' ) ) {
		return;
	}

	$elementor_theme_manager->register_all_core_location();
}

add_action( 'elementor/theme/register_locations', 'azeria_elementor_locations' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Post format specific template tags.
 */
require get_template_directory() . '/inc/template-post-formats.php';

/**
 * Functions hooked to custom theme actions.
 */
require get_template_directory() . '/inc/template-actions.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load SVG icons class.
 */
require get_template_directory() . '/inc/classes/class-svg-icons.php';
