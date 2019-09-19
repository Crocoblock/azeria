/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
( function() {
	var container, button, menu, links, subMenus;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}
} )();

/**
 * Simple drop down menu plugin
 */
(function ($) {
	"use strict";

	$.fn.azeriaMenu = function() {

		var menu = $(this),
			duration_timeout,
			closeSubs, 
			hideSub, 
			showSub, 
			init;

		closeSubs = function() {
			$('.menu-hover > a', menu).each(
				function() {
					hideSub( $(this) );
				}
			);
		};

		hideSub = function( anchor ) {
			
			anchor.parent().removeClass('menu-hover').triggerHandler('close_menu');
			
			anchor.siblings('ul').addClass('in-transition');

			clearTimeout( duration_timeout );
			duration_timeout = setTimeout(
				function() {
					anchor.siblings('ul').removeClass('in-transition');
				},
				200
			);
		};

		showSub = function( anchor ) {

			// all open children of open siblings
			var item = anchor.parent();

			item
				.siblings()
				.find('.menu-hover')
				.addBack('.menu-hover')
				.children('a')
				.each(function() {
					hideSub($(this), true);
				});

			item.addClass('menu-hover').triggerHandler('open_menu');
		};

		init = function() {

			$('li.menu-item-has-children, li.page_item_has_children', menu).hoverIntent({
				over: function () {
					showSub( $(this).children('a') );
				},
				out: function () {
					if ( $(this).hasClass('menu-hover') ) {
						hideSub( $(this).children('a') );
					}
				},
				timeout: 300
			});

		};

		init();
	};

}(jQuery));

jQuery(document).ready(function($){
	"use strict";
	$('div.menu > ul, ul.menu', $('#site-navigation') ).azeriaMenu();
});