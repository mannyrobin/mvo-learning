jQuery( function($) {
	var searchBg, searchBtnColor;
    $('.hip-colorpicker').wpColorPicker();
	$.ajax({
		method: 'GET',
		url: tabbar.api.url,
		dataType: 'json',
		beforeSend: function(xhr) {
			xhr.setRequestHeader('X-WP-Nonce', tabbar.api.nonce);
		}
	}).then( function(r) {
		if ( r.hasOwnProperty('tab') ){
			r.tab.forEach( function (value, index) {
				$('#tab' + index + '_name').val( value.name );
				$('#tab' + index + '_button').val( value.button );
				$('#tab' + index + '_svg').val( value.svg );
				$('#tab' + index + '_type').val( value.type );
				$('#tab' + index + '_link').val( value.link );
			} );
		}
		if(r.hasOwnProperty('enable_search')){
			if(r.enable_search){
				$('#enable_search').prop('checked',true);
                $('#search_bg, #search_btn_color').attr('disabled',false);
                if(r.hasOwnProperty('search_bg')){
                    $('#search_bg').wpColorPicker('color',r.search_bg );
                    searchBg = r.search_bg;
                }
                if(r.hasOwnProperty('search_btn_color')){
                    $('#search_btn_color').wpColorPicker('color', r.search_btn_color );
                    searchBtnColor = r.search_btn_color;
                }

			}else{
                $('#enable_search').prop('checked',false);
                $('#search_bg, #search_btn_color').val('').attr('disabled',true);
			}
		}

		if ( r.hasOwnProperty('max_width') ) {
			$('#max_width').val( r.max_width );
		}
		
		if ( r.hasOwnProperty('bg_color') ) {
			$('#bg_color').wpColorPicker('color', r.bg_color );
		}
		
		if ( r.hasOwnProperty('fg_color') ) {
			$('#fg_color').wpColorPicker('color', r.fg_color );
		}
		
		if ( r.hasOwnProperty('selected_color') ) {
			$('#selected_color').wpColorPicker('color', r.selected_color );
		}
	} );
	$('#enable_search').on('click',function(){
		if($(this).prop('checked')){
            $('#search_bg, #search_btn_color').attr('disabled',false);
			$('#search_bg').wpColorPicker('color', searchBg);
            $('#search_btn_color').wpColorPicker('color', searchBtnColor );
		}else{
            $('#search_bg, #search_btn_color').val('').attr('disabled',true);
		}
	});
	
	$( '#tabbar-form' ).on( 'submit', function(e) {
		e.preventDefault();
		var data = $('#tabbar-form').serializeArray();

		$.ajax({
			method: 'POST',
			url: tabbar.api.url,
			beforeSend: function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', tabbar.api.nonce );
                $('.hip-settings').fadeTo(100, 0.5);
			},
			data: data,
			success: function(r) {
                $('#feedback').fadeIn(100).html('<p class="success">' + tabbar.strings.saved + '</p>');
			},
			error: function(r) {
				var message = tabbar.strings.error;
				if( r.hasOwnProperty('message' ) ) {
					message = r.message;
				}
                $('#feedback').fadeIn(100).html('<p class="failure">' + message + '</p>');
			},
            complete: function(){
                setTimeout(function() {
                    $('#feedback').fadeOut(200);
                }, 2500);
                $('.hip-settings').fadeTo(100, 1);
            }
		});
	} )
} );
