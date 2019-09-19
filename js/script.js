/**
 * Custom Azeria JS inits etc.
 */
(function($) {
	"use strict";

	$(function(){

		// Try to init main slider
		var $slider = $('.slider-box'),
			_args;

		if ( $slider.length ) {

			_args = $slider.data( 'args' );
			$slider.slick( _args );

		}

		// Try to init post format gallery slider
		var $gallery = $('.entry-gallery'),
			_gall_args;

		if ( $gallery.length ) {

			_gall_args = $gallery.data( 'init' );
			$gallery.slick( _gall_args );

		}

		// Init single image popup
		$('.image-popup').each(function( index, el ) {
			$(this).magnificPopup({type:'image'});
		});

		// Init gallery images popup
		$('.popup-gallery').each(function(index, el) {

			var _this     = $(this),
				gall_init = _this.data( 'popup-init' );

			_this.magnificPopup( gall_init );

		});

		// to top button
		$('#back-top').on('click', 'a', function(event) {
			event.preventDefault();
			$('body,html').stop(false, false).animate({
				scrollTop: 0
			}, 800);
			return !1;
		});

	});

})(jQuery);