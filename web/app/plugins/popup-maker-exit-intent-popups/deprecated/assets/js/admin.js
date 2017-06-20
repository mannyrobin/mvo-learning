(function ($, document, undefined) {
    "use strict";
    $(document).ready(function () {
        if ($('body.post-type-popup form#post').length) {
            var type_check = function () {
                    var val = $("#popup_exit_intent_type").val();
                    $('.exit-intent-enabled').filter('.hard-only,.soft-only,.alert-only').hide();
                    if (val === 'hard' || val === 'both') {
                        $('.exit-intent-enabled.hard-only').show();
                    }
                    if (val === 'soft' || val === 'both') {
                        $('.exit-intent-enabled.soft-only').show();
                    }
                    if (val === 'alert') {
                        $('.exit-intent-enabled.alert-only').show();
                    }
                },
                cookie_check = function () {
                    if ($("#popup_exit_intent_cookie_trigger").val() !== 'disabled') {
                        $('.exit-intent-enabled.cookie-enabled').show();
                    } else {
                        $('.exit-intent-enabled.cookie-enabled').hide();
                    }
                },
                enable_check = function () {
                    if (!$("#popup_exit_intent_enabled").is(':checked')) {
                        $('.exit-intent-enabled').hide();
                    } else {
                        $('.exit-intent-enabled').show();
                        type_check();
                        cookie_check();
                    }
                },
                reset_cookie_key = function () {
                    $('#popup_exit_intent_cookie_key').val((new Date().getTime()).toString(16));
                };

            $(document)
                .on('click', "#popup_exit_intent_enabled", enable_check)
                .on('change', "#popup_exit_intent_type", type_check)
                .on('change', "#popup_exit_intent_cookie_trigger", cookie_check)
                .off('click', ".popmake-reset-exit-intent-cookie-key")
                .on('click', ".popmake-reset-exit-intent-cookie-key", reset_cookie_key);

            enable_check();

            if ($('#popup_exit_intent_cookie_key').val() === '') {
                reset_cookie_key();
            }
        }
    });
}(jQuery, document));