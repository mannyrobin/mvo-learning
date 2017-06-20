(function ($, document) {
    "use strict";
    $.extend($.fn.popmake.triggers, {
        exit_intent: function (settings) {
            var $popup = PUM.getPopup(this),
                sensitivity_delay = null; // Stores the timeout used for sensitivity delay. Used for soft exit.

            // Merge Defaults.
            settings = $.extend({
                top_sensitivity: 10,
                delay_sensitivity: 350
            }, settings);

            $(document)
                .on('mouseleave', function (e) {
                    if (e.clientY > settings.top_sensitivity) {
                        return;
                    }

                    sensitivity_delay = setTimeout(function () {
                        // Just before triggering if the popup is already open return.
                        if ($popup.hasClass('pum-open') || $popup.popmake('getContainer').hasClass('active')) {
                            return;
                        }

                        // If cookies exists return.
                        if ($popup.popmake('checkCookies', settings)) {
                            return;
                        }

                        // Set the global last open trigger to the a text description of the trigger.
                        $.fn.popmake.last_open_trigger = 'Exit Intent - Top:' + settings.top_sensitivity + '; Delay:' + settings.delay_sensitivity;

                        $popup.popmake('open');

                        sensitivity_delay = null;
                    }, settings.delay_sensitivity);
                })
                .on('mouseenter', function () {
                    clearTimeout(sensitivity_delay);
                });
        },
        exit_prevention: function (settings) {
            var $popup = PUM.getPopup(this),
                allow_unload = false; // Page can only be unloaded once this is true. Used for hard exit.

            // Merge Defaults.
            settings = $.extend({
                message: ''
            }, settings);

            window.onbeforeunload = function () {
                if (allow_unload) {
                    return;
                }

                // Just before triggering if the popup is already open return.
                if ($popup.hasClass('pum-open') || $popup.popmake('getContainer').hasClass('active')) {
                    return;
                }

                // If cookies exists return.
                if ($popup.popmake('checkCookies', settings)) {
                    return;
                }

                // Set the global last open trigger to the a text description of the trigger.
                $.fn.popmake.last_open_trigger = 'Exit Prevention - Message: ' + settings.message;

                $popup.popmake('open');

                allow_unload = true;

                return settings.message;
            };
        }
    });
}(jQuery, document));