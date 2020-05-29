jQuery( function($) {
	$.ajax({
		method: 'GET',
		url: hipstaff.api.url,
		dataType: 'json',
		beforeSend: function(xhr) {
			xhr.setRequestHeader('X-WP-Nonce', hipstaff.api.nonce);
		}
	}).then( function(r) {
		if ( r.hasOwnProperty('staff_singular_label') ) {
			$('#staff_singular_label').val( r.staff_singular_label );
		}
		if ( r.hasOwnProperty('staff_plural_label') ) {
			$('#staff_plural_label').val( r.staff_plural_label );
		}
		if(r.hasOwnProperty('staff_slug')){
			$('#staff_slug').val( r.staff_slug );
		}
		if ( r.hasOwnProperty('staff_cat_label') ) {
			$('#staff_cat_label').val( r.staff_cat_label );
		}
		if(r.hasOwnProperty('staff_cat_slug')){
			$('#staff_cat_slug').val( r.staff_cat_slug );
		}
	});
	
	$( '#staff-settings-form' ).on( 'submit', function(e) {
		e.preventDefault();
		var data = $('#staff-settings-form').serializeArray();

		$.ajax({
			method: 'POST',
			url: hipstaff.api.url,
			beforeSend: function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', hipstaff.api.nonce );
			},
			data: data,
			success: function(r) {
				$( '#feedback' ).html( '<p class="success">' + hipstaff.strings.saved + '</p>' );
			},
			error: function(r) {
				var message = hipstaff.strings.error;
				if( r.hasOwnProperty('message' ) ) {
					message = r.message;
				}
				$( '#feedback' ).html( '<p class="failure">' + message + '</p>' );
			}
		});
	} )
} );
