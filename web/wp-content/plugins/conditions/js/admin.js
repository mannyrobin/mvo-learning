jQuery( function($) {
	$.ajax({
		method: 'GET',
		url: hipconditions.api.url,
		dataType: 'json',
		beforeSend: function(xhr) {
			xhr.setRequestHeader('X-WP-Nonce', hipconditions.api.nonce);
		}
	}).then( function(r) {
		if ( r.hasOwnProperty('condition_singular_label') ) {
			$('#condition_singular_label').val( r.condition_singular_label );
		}
			if ( r.hasOwnProperty('condition_plural_label') ) {
			$('#condition_plural_label').val( r.condition_plural_label );
		}
		if(r.hasOwnProperty('condition_slug')){
			$('#condition_slug').val( r.condition_slug );
		}
		if ( r.hasOwnProperty('condition_cat_label') ) {
			$('#condition_cat_label').val( r.condition_cat_label );
		}
		if(r.hasOwnProperty('condition_cat_slug')){
			$('#condition_cat_slug').val( r.condition_cat_slug );
		}
	});
	
	$( '#conditions-settings-form' ).on( 'submit', function(e) {
		e.preventDefault();
		var data = $('#conditions-settings-form').serializeArray();

		$.ajax({
			method: 'POST',
			url: hipconditions.api.url,
			beforeSend: function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', hipconditions.api.nonce );
			},
			data: data,
			success: function(r) {
				$( '#feedback' ).html( '<p class="success">' + hipconditions.strings.saved + '</p>' );
			},
			error: function(r) {
				var message = hipconditions.strings.error;
				if( r.hasOwnProperty('message' ) ) {
					message = r.message;
				}
				$( '#feedback' ).html( '<p class="failure">' + message + '</p>' );
			}
		});
	} )
} );
