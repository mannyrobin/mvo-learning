jQuery( function($) {
    
	if ( $('.hip-settings').length ) {
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
                    $('#tab' + index + '_type').val( value.type );
                    $('#tab' + index + '_link').val( value.link );

                    /* set icon values*/
                    var button = value.button,
                        icon = value.icon,
                        oldIcon = value.svg;
                    $.each($('.tab-' + index + '-table').find('tr.icon-option'), function(index,value){
                        var option = $(value);
                        if(button === 'hamburger'){
                            option.fadeOut(100).addClass('hidden');
                        }else{
                            if(option.hasClass(button)){
                                if(button === 'image'){
                                    option.find('img').attr('src',icon).fadeIn(300)
                                }
                                option.fadeIn(300).removeClass('hidden');
                                if(oldIcon){
                                    option.find('input,textarea').val(oldIcon);
                                }else{
                                    option.find('input,textarea').val(icon);
                                }

                            }else{
                                option.fadeOut(100).addClass('hidden');
                                option.find('input,textarea').removeAttr('id name');
                            }
                        }
                    });
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

        $('.tab-icon-select').on('change',function(){
            var targetedRow = $(this).val(),
                table = $(this).closest('table'),
                options = table.find('tr.icon-option'),id,name;
            $.each(options.find('input[type="text"],textarea'),function(index,value){
                if(typeof $(value).attr('id') !== 'undefined'){
                    id = $(value).attr('id');
                }
                if(typeof $(value).attr('name') !== 'undefined'){
                    name = $(value).attr('name');
                }

            });
            $.each(options,function (index,value) {
                var option = $(value);
                if(targetedRow === 'hamburger'){
                    option.fadeOut(100).addClass('hidden');
                }else{
                    if(option.hasClass(targetedRow)){
                        option.fadeIn(300).removeClass('hidden');
                        option.find('input,textarea').attr({
                            'name': name,
                            'id': id
                        })
                    }else{
                        option.fadeOut(100).addClass('hidden');
                        option.find('input,textarea').removeAttr('id name');
                    }
                }
            })
        });
        $('.upload-btn').on('click', function (e) {
            e.preventDefault();
            var uploadBtn = $(this),
                media_uploader,
                imgProperty;
            media_uploader = wp.media({
                frame: "post",
                state: "insert",
                multiple: false
            });
            media_uploader.on("insert", function () {
                imgProperty = media_uploader.state().get("selection").first().toJSON();
                uploadBtn.prev('.preview-upload').attr('src', imgProperty.url).fadeIn(200);
                uploadBtn.next('input[type="text"]').val(imgProperty.url);
            });
            media_uploader.open();
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
    }
} );
