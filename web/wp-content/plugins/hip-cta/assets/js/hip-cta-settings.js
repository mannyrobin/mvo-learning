jQuery(function ($) {
    'use strict';
	$.ajax({
        method: 'GET',
        url: hipcta.api.url,
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', hipcta.api.nonce);
        }
    }).then(function (r) {
		for (var key in r) {
			if (r.hasOwnProperty(key)) {
				switch (key) {
					case 'hide_cta_on_mobile':
						if(r.hide_cta_on_mobile === 'on'){
							$('#hide_cta_on_mobile').prop('checked', true);
						}
						break;
					default:
						$('#' + key).val(r[key]);
				}

			}
		}
    });

    $('#hip-cta-settings-form').on('submit', function (e) {
        e.preventDefault();

        var data = $(this).serializeArray();
		if(data.length === 0){
			data = {
				'hide_cta_on_mobile' : 'off'
			};
		}
        $.ajax({
            method: 'POST',
            url: hipcta.api.url,
            beforeSend: function (xhr) {
                $('.cta-settings').fadeTo(100, 0.5);
                xhr.setRequestHeader('X-WP-Nonce', hipcta.api.nonce);
            },
            data: data,
            success: function (r) {
                $('#feedback').fadeIn(100).html('<p class="success">' + hipcta.strings.saved + '</p>');
            },
            error: function (r) {
                var message = hipcta.strings.error;
                if (r.hasOwnProperty('message')) {
                    message = r.message;
                }
                $('#feedback').fadeIn(100).html('<p class="failure">' + message + '</p>');
            },
            complete: function () {
                setTimeout(function () {
                    $('#feedback').fadeOut(200);
                }, 2500);
                $('.cta-settings').fadeTo(100, 1);
            }
        });
    });
});
