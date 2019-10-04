<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 *
 * @package azeria
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses azeria_header_style()
 * @uses azeria_admin_header_style()
 * @uses azeria_admin_header_image()
 */
function azeria_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'azeria_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '686868',
		'width'                  => 1920,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'azeria_header_style',
		'admin-head-callback'    => 'azeria_admin_header_style',
		'admin-preview-callback' => 'azeria_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'azeria_custom_header_setup' );

if ( ! function_exists( 'azeria_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see azeria_custom_header_setup().
 */
function azeria_header_style() {

	$header_text_color = get_header_textcolor();
	$header_image      = get_header_image();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: add_theme_support( 'custom-header' ) is default, hide text (returns 'blank') or any hex value.
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	<?php
		if ( $header_image ) :
	?>
	.site-branding {
		background-image: url('<?php echo esc_url( $header_image ); ?>');
		background-repeat: no-repeat;
		background-position: center top;
		background-size: cover;
	}
	<?php endif; ?>
	</style>
	<?php
}
endif; // azeria_header_style

if ( ! function_exists( 'azeria_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see azeria_custom_header_setup().
 */
function azeria_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // azeria_admin_header_style

if ( ! function_exists( 'azeria_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see azeria_custom_header_setup().
 */
function azeria_admin_header_image() {
?>
	<div id="headimg">
		<h1 class="displaying-header-text">
			<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // azeria_admin_header_image
