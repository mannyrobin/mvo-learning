jQuery(function ($) {
	'use strict';
	
	if ( $('.hip-settings').length ) {

        $('.hip-colorpicker').wpColorPicker();
        $.ajax({
            method: 'GET',
            url: business_info.api.url,
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', business_info.api.nonce);
            }
        }).then(function (r) {

            if(r.hasOwnProperty('businessinfo_phone_number')){
                $('#businessinfo_phone_number').val( r.businessinfo_phone_number );
            }
            if(r.hasOwnProperty('businessinfo_address')){
                $('#businessinfo_address').val( r.businessinfo_address );
            }
            if(r.hasOwnProperty('businessinfo_specialty')) {
                $('#businessinfo_specialty').val( r.businessinfo_specialty );
            }
            if ( r.hasOwnProperty('social_media') ) {
                var fields='';
                $.each(r.social_media,function(index,value) {
                    fields += repeatableFieldInput(index,value);
                });
                $('.repeatable-field').replaceWith(fields);

            }
            /**
            * for converting old social icon values into new one
            * can be removed after 3-4 update cycle
            */
            var oldIcons = '', oldIconIndex = 0;
            if(r.hasOwnProperty('businessinfo_facebook_icon') && r.hasOwnProperty('businessinfo_facebook_link')){
                oldIcons += repeatableFieldInput(oldIconIndex,{
                    icon : r.businessinfo_facebook_icon,
                    link : r.businessinfo_facebook_link
                });
                oldIconIndex++;
            }
            if(r.hasOwnProperty('businessinfo_twitter_icon') && r.hasOwnProperty('businessinfo_twitter_link')){
                oldIcons += repeatableFieldInput(oldIconIndex,{
                    icon : r.businessinfo_twitter_icon,
                    link : r.businessinfo_twitter_link
                });
                oldIconIndex++;
            }
            if(r.hasOwnProperty('businessinfo_instagram_icon') && r.hasOwnProperty('businessinfo_instagram_link')){
                oldIcons += repeatableFieldInput(oldIconIndex,{
                    icon : r.businessinfo_instagram_icon,
                    link : r.businessinfo_instagram_link
                });
                oldIconIndex++;
            }
            if(r.hasOwnProperty('businessinfo_linkedin_icon') && r.hasOwnProperty('businessinfo_linkedin_link')){
                oldIcons += repeatableFieldInput(oldIconIndex,{
                    icon : r.businessinfo_linkedin_icon,
                    link : r.businessinfo_linkedin_link
                });
                oldIconIndex++;
            }
            if(r.hasOwnProperty('businessinfo_google_icon') && r.hasOwnProperty('businessinfo_google_link')){
                oldIcons += repeatableFieldInput(oldIconIndex,{
                    icon : r.businessinfo_google_icon,
                    link : r.businessinfo_google_link
                });
                oldIconIndex++;
            }
            if(r.hasOwnProperty('businessinfo_youtube_icon') && r.hasOwnProperty('businessinfo_youtube_link')){
                oldIcons += repeatableFieldInput(oldIconIndex,{
                    icon : r.businessinfo_youtube_icon,
                    link : r.businessinfo_youtube_link
                });
                oldIconIndex++;
            }
            if(r.hasOwnProperty('businessinfo_pinterest_icon') && r.hasOwnProperty('businessinfo_pinterest_link')){
                oldIcons += repeatableFieldInput(oldIconIndex,{
                    icon : r.businessinfo_pinterest_icon,
                    link : r.businessinfo_pinterest_link
                });
                oldIconIndex++;
            }
            if(oldIconIndex > 0){
                $('.repeatable-field').replaceWith(oldIcons);
            }
            if(r.hasOwnProperty('social_media_height')){
                $('#social_media_height').val( r.social_media_height );
            }
            if(r.hasOwnProperty('social_media_width')){
                $('#social_media_width').val( r.social_media_width );
            }
            if(r.hasOwnProperty('icon_font_size')){
                $('#icon_font_size').val( r.icon_font_size );
            }
            if(r.hasOwnProperty('social_brand_styles')){
                if(r.social_brand_styles){
                    $('#social_brand_styles').prop('checked',true);
                    $('#no-brand').fadeOut(300);
                }
            }
            else{
                $('#social_brand_styles').prop('checked',false);
                $('#no-brand').fadeIn(300);
                if(r.hasOwnProperty('social_icon_color')){
                    $('#social_icon_color').wpColorPicker('color', r.social_icon_color );
                }
                if(r.hasOwnProperty('social_icon_hover_color')){
                    $('#social_icon_hover_color').wpColorPicker('color', r.social_icon_hover_color );
                }
                if(r.hasOwnProperty('social_icon_bg')){
                    $('#social_icon_bg').wpColorPicker('color', r.social_icon_bg );
                }
                if(r.hasOwnProperty('social_icon_hover_bg')){
                    $('#social_icon_hover_bg').wpColorPicker('color', r.social_icon_hover_bg );
                }
            }

        });

        function telephonecheck(number){
            var regex = /^(\+?1\s?)?[\s\-\.]?((\(\d{3}\) ?)|(\d{3}))[\s\-\.]?\d{3}[\s\-\.]?\d{4}$/;
            return regex.test(number.replace(/\s/g, ''));
        }

        $('#businessinfo_phone_number').focusout(function () {
            var isValidPhone = telephonecheck($(this).val());
            if($(this).val() === ''){
                return false;
            }else{
                if (isValidPhone) {
                    $('.validation-txt').html(' ✓ valid phone Number').css({'color': 'green'});
                } else {
                    $('.validation-txt').html('✘ Invalid phone Number').css({'color': 'red'});
                }
            }

        });

        //social media brand styles set or unset
        $('#social_brand_styles').on('click',function(){
            if($(this).prop('checked')){
                $('#no-brand').fadeOut(300);
            }else{
                $('#no-brand').fadeIn(300);
            }
        });

        $(document).on('click','.add-field',function(e){
            e.preventDefault();
            var btn = $(this),
                repeatableFields = $('.repeatable-field');
            if(repeatableFields.length > 0){
                var lastItem = repeatableFields.last();
                lastItem.after(repeatableFieldInput(parseInt(lastItem.data('index') + 1)));
            }else{
                console.log(btn.parents('tr').after(repeatableFieldInput(parseInt(0))));
            }

        });

        $(document).on('click','.remove-field',function(e){
            e.preventDefault();
            var btn = $(this);
            btn.parents('tr').remove();

        });

        $( '#hip-businessinfo-form' ).on( 'submit', function(e) {
            e.preventDefault();

            var data = $(this).serializeArray();
            $.ajax({
                method: 'POST',
                url: business_info.api.url,
                beforeSend: function (xhr) {
                    $('.hip-settings').fadeTo(100, 0.5);
                    xhr.setRequestHeader('X-WP-Nonce', business_info.api.nonce);
                },
                data: data,
                success: function (r) {
                    if(r.hasOwnProperty('invalid_phone_number')){
                        if(r.invalid_phone_number){
                            $('#feedback').fadeIn(100).html('<p class="failure">Phone number is not valid!!</p>');
                        }
                    }
                    else{
                        $('#feedback').fadeIn(100).html('<p class="success">' + business_info.strings.saved + '</p>');
                    }
                    console.log(r);
                },
                error: function (r) {
                    var message = business_info.strings.error;
                    if (r.hasOwnProperty('message')) {
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
        });

        var repeatableFieldInput = function(index,value){

            index = index || 0;
            var html = '',icon='',link='';
            if(typeof value !== 'undefined'){
                if(value.hasOwnProperty('icon')){
                    icon = value.icon
                }
                if(value.hasOwnProperty('link')){
                    link = value.link
                }
            }

            html += ' <tr data-index="'+index+'" class="repeatable-field">';

            /*icon*/
            html += '<td><p><label for="social_media['+index+'][icon]">Icon class</label></p>';
            html += '<input type="text" list="icons" id="social_media['+index+'][icon]" class="regular-text" name="social_media['+index+'][icon]" value="'+icon+'"></td>';

            /*link*/
            html += '<td><p><label for="social_media['+index+'][link]">Icon link</label></p>';
            html += '<input type="text" id="social_media['+index+'][link]" class="regular-text" name="social_media['+index+'][link]" value="'+link+'"></td>';

            /*add & remove button */
            html += '<td>' +
                '<button type="button" class="button-primary add-field">Add</button>' +
                '<button type="button" class="button-secondary remove-field" >Remove</button>' +
                '</td></tr>';

            return html;
        };
    }
});
