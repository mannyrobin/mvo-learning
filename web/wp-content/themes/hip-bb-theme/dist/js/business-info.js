jQuery(function ($) {
    'use strict';

    $('.hip-colorpicker').wpColorPicker();
    $.ajax({
        method: 'GET',
        url: business_info.api.url,
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', business_info.api.nonce);
        }
    }).then(function (r) {
        if ( r.hasOwnProperty('businessinfo_phone_number') ) {
            $('#businessinfo_phone_number').val( r.businessinfo_phone_number );
        }
        if(r.hasOwnProperty('businessinfo_address')){
            $('#businessinfo_address').val( r.businessinfo_address );
        }
        if ( r.hasOwnProperty('businessinfo_facebook_icon') ) {
            $('#businessinfo_facebook_icon').val( r.businessinfo_facebook_icon );
        }
        if(r.hasOwnProperty('businessinfo_facebook_link')){
            $('#businessinfo_facebook_link').val( r.businessinfo_facebook_link );
        }
        if(r.hasOwnProperty('businessinfo_twitter_icon')){
            $('#businessinfo_twitter_icon').val( r.businessinfo_twitter_icon );
        }
        if(r.hasOwnProperty('businessinfo_twitter_link')){
            $('#businessinfo_twitter_link').val( r.businessinfo_twitter_link );
        }
        if(r.hasOwnProperty('businessinfo_instagram_icon')){
            $('#businessinfo_instagram_icon').val( r.businessinfo_instagram_icon );
        }
        if(r.hasOwnProperty('businessinfo_instagram_link')){
            $('#businessinfo_instagram_link').val( r.businessinfo_instagram_link );
        }
        if(r.hasOwnProperty('businessinfo_linkedin_icon')){
            $('#businessinfo_linkedin_icon').val( r.businessinfo_linkedin_icon );
        }
        if(r.hasOwnProperty('businessinfo_linkedin_link')){
            $('#businessinfo_linkedin_link').val( r.businessinfo_linkedin_link );
        }
        if(r.hasOwnProperty('businessinfo_google_icon')){
            $('#businessinfo_google_icon').val( r.businessinfo_google_icon );
        }
        if(r.hasOwnProperty('businessinfo_google_link')){
            $('#businessinfo_google_link').val( r.businessinfo_google_link );
        }
        if(r.hasOwnProperty('businessinfo_youtube_icon')){
            $('#businessinfo_youtube_icon').val( r.businessinfo_youtube_icon );
        }
        if(r.hasOwnProperty('businessinfo_youtube_link')){
            $('#businessinfo_youtube_link').val( r.businessinfo_youtube_link );
        }
        if(r.hasOwnProperty('businessinfo_pinterest_icon')){
            $('#businessinfo_pinterest_icon').val( r.businessinfo_pinterest_icon);
        }
        if(r.hasOwnProperty('businessinfo_pinterest_link')){
            $('#businessinfo_pinterest_link').val( r.businessinfo_pinterest_link );
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

});
