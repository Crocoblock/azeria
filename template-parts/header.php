<?php
/**
 * Template part for displaying the header.
 *
 * @package azeria
 */
?>

<header id="masthead" class="site-header" role="banner">
	<div class="site-branding">
		<div class="container">
			<?php azeria_logo(); ?>
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>
		</div>
	</div><!-- .site-branding -->

	<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="container">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<?php echo azeria_get_icon_svg( 'bars', array( 'toggle-icon-normal' ) ); ?>
				<?php echo azeria_get_icon_svg( 'close', array( 'toggle-icon-active' ) ); ?>
				<?php esc_html_e( 'Menu', 'azeria' ); ?>
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu'
				)
			);
			?>
		</div>
	</nav><!-- #site-navigation -->
</header><!-- #masthead -->

<?php do_action( 'azeria_showcase_area' ); ?>
