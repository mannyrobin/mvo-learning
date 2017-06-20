(function ($, document, undefined) {
    "use strict";
    var defaults = {
        type: 'soft',
        hard_message: '',
        cookie_trigger: 'close',
        cookie_time: '1 month',
        cookie_path: '/',
        cookie_key: '1',
        top_sensitivity: 10,
        delay_sensitivity: 350
    };
    $('.popmake.exit-intent')
        .on('popmakeInit', function () {
            var $this = $(this),
                settings = $this.data('popmake'),
                allow_unload = false,
                exit_intent = $.extend({}, defaults, settings.meta.exit_intent),
                opened = false,
                noCookieCheck = function () {
                    return $.pm_cookie("popmake-exit-intent-" + settings.id + "-" + exit_intent.cookie_key) === undefined;
                },
                triggered = null;

            $this
                // Set cookie on triggered event.
                .on('popmakeSetCookie.exit-intent', function () {
                    if (exit_intent.cookie_time !== '' && noCookieCheck()) {
                        $.pm_cookie(
                            "popmake-exit-intent-" + settings.id + "-" + exit_intent.cookie_key,
                            true,
                            exit_intent.cookie_time,
                            exit_intent.cookie_path
                        );
                    }
                })
                .on('popmakeAfterOpen', function () {
                    if (exit_intent.cookie_trigger === 'open') {
                        $this.trigger('popmakeSetCookie.exit-intent');
                    }
                })
                .on('popmakeBeforeClose', function () {
                    if (exit_intent.cookie_trigger === 'close') {
                        $this.trigger('popmakeSetCookie.exit-intent');
                    }
                });

            if (exit_intent.type === 'soft' || exit_intent.type === 'both') {
                $(document)
                    .on('mouseleave', function (event) {
                        if (event.clientY > exit_intent.top_sensitivity || !noCookieCheck() || opened) {
                            return;
                        }
                        triggered = setTimeout(function () {
                            $.fn.popmake.last_open_trigger = 'Exit Popup ID-' + settings.id;
                            opened = true;
                            $this.popmake('open');
                            triggered = null;
                        }, exit_intent.delay_sensitivity);
                    })
                    .on('mouseenter', function () {
                        if (triggered !== null) {
                            clearTimeout(triggered);
                        }
                    });
            }
            if (exit_intent.type === 'hard' || exit_intent.type === 'both') {
                window.onbeforeunload = function () {
                    if (!noCookieCheck() || allow_unload || opened) {
                        return;
                    }
                    $.fn.popmake.last_open_trigger = 'Exit Popup ID-' + settings.id;
                    opened = true;
                    $this.popmake('open');
                    allow_unload = true;
                    return exit_intent.hard_message;
                };
            }
            if (exit_intent.type === 'alert') {
                window.onbeforeunload = function () {
                    if (!noCookieCheck() || allow_unload || opened) {
                        return;
                    }
                    opened = true;
                    allow_unload = true;
                    $this.trigger('popmakeSetCookie.exit-intent');
                    return exit_intent.hard_message;
                };
            }
        });
}(jQuery, document));