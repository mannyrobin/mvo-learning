(function($) {

	var toggle = $("header .c-hamburger");
	var mobilemenu = $("header .mobile-menu-wrap");

	toggleHandler(toggle);

	function toggleHandler(toggle) {
		toggle.click( function(e) {
			e.preventDefault();
			$(this).toggleClass('is-active');
			mobilemenu.slideToggle();
			mobilemenu.toggleClass('is-open');
			$('body').toggleClass('prevent-scroll');
		});

		mobilemenu.find('.menu-item-has-children > a').removeAttr('href');
		mobilemenu.find('.menu-item-has-children').click( function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).children('.sub-menu').slideToggle();
			$(this).toggleClass('rotated');
		} );
		mobilemenu.find('.sub-menu li:not(.menu-item-has-children) a').click( function(e) {
			e.stopPropagation();
		} );
	}


	/**
	 * Determine the mobile operating system.
	 * This function returns one of 'iOS', 'Android', 'Windows Phone', or 'unknown'.
	 *
	 * @returns {String}
	 */
	function getMobileOperatingSystem() {
		var userAgent = navigator.userAgent || navigator.vendor || window.opera;

		// Windows Phone must come first because its UA also contains "Android"
		if (/windows phone/i.test(userAgent)) {
			return "Windows Phone";
		}

		if (/android/i.test(userAgent)) {
			return "Android";
		}

		// iOS detection from: http://stackoverflow.com/a/9039885/177710
		if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
			return "iOS";
		}

		return "unknown";
	}

	function toggleMenu( menu ) {
		if ( menu.parent().hasClass('selected') ) {
			menu.parent().removeClass('selected');
		} else {
			menu.parent().addClass('selected');
		}

		menu.parent().siblings('.tab').removeClass('selected');
	}

	// Tricks iOS tool bar to stay open at all times.
	if ( getMobileOperatingSystem() == 'iOS' ){

		$('html').css( 'height', '100%' );
		$('html').css( 'overflow-y', 'scroll' );
		$('html').css( '-webkit-overflow-scrolling', 'touch' );

		$('body').css( 'height', '100%' );
		$('body').css( 'overflow-y', 'scroll' );
		$('body').css( '-webkit-overflow-scrolling', 'touch' );

		$(window).on('load',function(){
			var datePickerFields = $('.flatpickr-input');
			if(datePickerFields.length > 0){
				datePickerFields.each(function(){
					$(this).on('focus',function(){
						$('html').css('overflow-y','unset');
						$('body').css('overflow-y','unset');
					});
					$(this).on('change',function(){
						$('html').css('overflow-y','scroll');
						$('body').css('overflow-y','scroll');
					})
				});
			}
		});
	}

	$('.tab .menu li.page_item_has_children, .tab .menu li.menu-item-has-children').children('a').removeAttr('href');

	$('.tab .menu li.page_item_has_children, .tab .menu li.menu-item-has-children').on( 'click', function(e) {
		e.stopPropagation();
		e.preventDefault();
		$(this).toggleClass('selected');
		$(this).children('ul').slideToggle();
	});

	$('.tab .sub-menu li:not(.menu-item-has-children) a').click( function(e) {
		e.stopPropagation();
	});

	$('.tab button').click( function() {
		if ( $(this).data('url') ) {
			$(this).parent().addClass('selected');
			location = $(this).data('url');
		} else {
			toggleMenu( $(this).parent().children('div') );
		}
	});
})(jQuery);