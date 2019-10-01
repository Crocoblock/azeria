/**
 * Custom Azeria JS inits etc.
 */
(function($) {
	"use strict";

	$(function(){

		// Try to init main slider
		var $slider = $('.slider-box'),
			$sliderItems,
			_args;

		if ( $slider.length ) {
			$sliderItems = $( '.slider-items', $slider );
			_args = $slider.data( 'args' );

			$sliderItems.slick( _args );

		}

		// Try to init post format gallery slider
		var $gallery = $('.entry-gallery');

		if ( $gallery.length ) {

			$gallery.each(function(){
				var _this = $( this ),
					_gall_items = $('.entry-gallery-items', _this),
					_gall_args = _this.data( 'init' );

				_gall_items.slick( _gall_args );
			});

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