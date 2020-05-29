jQuery( function($) {
    $.ajax({
        method: 'GET',
        url: hiplp.api.url,
        dataType: 'json',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', hiplp.api.nonce);
        }
    }).then( function(r) {
        if ( r.hasOwnProperty('lp_label') ) {
            $('#lp_label').val( r.lp_label );
        }
        if(r.hasOwnProperty('lp_slug')){
            $('#lp_slug').val( r.lp_slug );
        }
        if ( r.hasOwnProperty('lp_cat_label') ) {
            $('#lp_cat_label').val( r.lp_cat_label );
        }
        if(r.hasOwnProperty('lp_cat_slug')){
            $('#lp_cat_slug').val( r.lp_cat_slug );
        }
    });

    $( '#lp-settings-form' ).on( 'submit', function(e) {
        e.preventDefault();
        var data = $('#lp-settings-form').serializeArray();

        $.ajax({
            method: 'POST',
            url: hiplp.api.url,
            beforeSend: function ( xhr ) {
                xhr.setRequestHeader( 'X-WP-Nonce', hiplp.api.nonce );
            },
            data: data,
            success: function(r) {
                $( '#feedback' ).html( '<p class="success">' + hiplp.strings.saved + '</p>' );
            },
            error: function(r) {
                var message = hiplp.strings.error;
                if( r.hasOwnProperty('message' ) ) {
                    message = r.message;
                }
                $( '#feedback' ).html( '<p class="failure">' + message + '</p>' );
            }
        });
    } )
} );