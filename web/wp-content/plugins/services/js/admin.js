jQuery( function($) {
    $.ajax({
        method: 'GET',
        url: hipservices.api.url,
        dataType: 'json',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', hipservices.api.nonce);
        }
    }).then( function(r) {
        for (var key in r) {
            if (r.hasOwnProperty(key)) {
                $('#' + key).val(r[key]);
            }
        }
    });

    $( '#services-settings-form' ).on( 'submit', function(e) {
        e.preventDefault();
        var data = $('#services-settings-form').serializeArray();

        $.ajax({
            method: 'POST',
            url: hipservices.api.url,
            beforeSend: function (xhr) {
                $('.hip-service-settings ').fadeTo(100, 0.5);
                xhr.setRequestHeader('X-WP-Nonce', hipservices.api.nonce);
            },
            data: data,
            success: function (r) {
                $('#feedback').fadeIn(100).html('<p class="success">' + hipservices.strings.saved + '</p>');

            },
            error: function (r) {
                var message = hipservices.strings.error;
                if (r.hasOwnProperty('message')) {
                    message = r.message;
                }
                $('#feedback').fadeIn(100).html('<p class="failure">' + message + '</p>');
            },
            complete: function () {
                setTimeout(function () {
                    $('#feedback').fadeOut(200);
                }, 2500);
                $('.hip-service-settings ').fadeTo(100, 1);
            }

        });
    })
} );
