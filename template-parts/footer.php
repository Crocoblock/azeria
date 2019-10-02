<?php
/**
 * Template part for displaying the footer.
 *
 * @package azeria
 */
?>

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="footer-widget-area">
		<div class="container">
			<div class="row">
				<?php
				foreach ( array( 'footer-sidebar-1', 'footer-sidebar-2', 'footer-sidebar-3' ) as $footer_sidebar ) {

					if ( ! is_active_sidebar( $footer_sidebar ) ) {
						continue;
					}
					?>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<?php dynamic_sidebar( $footer_sidebar ); ?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<div class="site-info">
		<div class="container">
			<?php
			azeria_to_top();
			$azeria_custm_copyright = azeria_get_option( 'footer_copyright' );
			if ( ! empty( $azeria_custm_copyright ) ) {
				echo esc_textarea( $azeria_custm_copyright );
			} else {
				?>
				<a rel="nofollow" href="<?php echo esc_url( __( 'http://wordpress.org/', 'azeria' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'azeria' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by <a href="%2$s" rel="nofollow">Crocoblock</a>.', 'azeria' ), 'Azeria', esc_url( 'https://crocoblock.com/' ) ); ?>
			<?php } ?>
		</div>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
