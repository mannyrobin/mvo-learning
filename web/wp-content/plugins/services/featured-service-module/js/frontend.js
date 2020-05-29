(function ($) {
    var savedWidth = $(document).width();
    var breakpoint = 993;

    $(document).ready(function () {
        if ($(window).width() >= breakpoint) {
            defaultService();
        }

    });
    $(window).resize(function () {
        var currentWidth = $(document).width();

        if (currentWidth >= breakpoint && savedWidth < breakpoint) {
            defaultService();
            savedWidth = currentWidth;
        }
        if (currentWidth < breakpoint && savedWidth >= breakpoint) {
            closeService($('.homepage-services-service'));
            savedWidth = currentWidth;
        }
    });

    $('.homepage-services-service-title a').click(function (e) {
        e.preventDefault();
    });

    $('.homepage-services-service').click(function (e) {
        closeService($(this).siblings('.homepage-services-service'));

        if ($(window).width() < breakpoint) {
            $(this).toggleClass('active');
            $(this).children('.homepage-services-service-inner').slideToggle();
        } else {
            $(this).addClass('active');
            $(this).children('.homepage-services-service-inner').stop().show();
        }
    });

    var closeService = function ($selector) {
        $selector.removeClass('active');
        if ($(window).width() < breakpoint) {
            $selector.children('.homepage-services-service-inner').slideUp();
        } else {
            $selector.children('.homepage-services-service-inner').stop().hide();
        }
    };

    var defaultService = function () {
        closeService($('.homepage-services-service'));
        $('.homepage-services-service:first-child').addClass('active');
        $('.homepage-services-service:first-child').children('.homepage-services-service-inner').show();
    };


    var $services = $('.homepage-services-service');
    var $window = $(window);

    $(document).ready(check_if_service_in_view());
    $window.on('scroll', check_if_service_in_view);

    function check_if_service_in_view() {
        var window_height = $window.height();
        var window_top_position = $window.scrollTop();
        var window_bottom_position = (window_top_position + window_height);

        $.each($services, function () {
            var $element = $(this);
            var element_height = $element.outerHeight();
            var element_top_position = $element.offset().top;
            var element_bottom_position = (element_top_position + element_height);

            //check to see if this current container is within viewport
            if ((element_bottom_position >= window_top_position) &&
                (element_top_position <= window_bottom_position)) {
                $element.addClass('in-view');
            }
        });
    }
})(jQuery);
