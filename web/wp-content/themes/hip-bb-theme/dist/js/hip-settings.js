jQuery(function ($) {
    'use strict';

    $('.hip-colorpicker').wpColorPicker();
    $.ajax({
        method: 'GET',
        url: hipSettings.api.url,
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', hipSettings.api.nonce);
        }
    }).then(function (r) {
        for (var key in r) {
            if (r.hasOwnProperty(key)) {
                switch (key) {
                    case 'logo_type':
                        if (r[key] == 'img') {
                            $('.svg_logo').hide();
                            $('.img_logo').show();
                        }
                        $('#' + key).val(r[key]);
                        break;
                    case 'alt_logo_type':
                        if (r[key] == 'alt_img') {
                            $('.alt_svg_logo').hide();
                            $('.alt_img_logo').show();
                        }
                        $('#' + key).val(r[key]);
                        break;
                    case 'logo_img':
                        $('.site_logo.logo').attr('src', r[key]);
                        $('#logo_img').val(r[key]);
                        break;
                    case 'alt_logo_img':
                        $('.site_logo.alt_logo').attr('src', r[key]);
                        $('#alt_logo_img').val(r[key]);
                        break;
                    case 'body_font_weight':
                        $('#body_font_weight').html(makeOptions(hipSettings.google_fonts[r.body_font]['weights']));
                        $('#' + key).val(r[key]);
                        break;

                    case 'header_font_weight':
                        $('#header_font_weight').html(makeOptions(hipSettings.google_fonts[r.header_font]['weights']));
                        $('#' + key).val(r[key]);
                        break;
                    default:
                        if(key.includes('_color')){
                            $('#'+key).wpColorPicker('color', r[key]);
                        }
                        $('#' + key).val(r[key]);
                }

            }
        }
    });

    $('.google-font').on('change', function () {
        var selected_font = $(this).val(),
            fontWeights = hipSettings.google_fonts[selected_font]['weights'],
            fontWeightSelect = $(this).attr('id') + '_weight';
        $('#' + fontWeightSelect).html(makeOptions(fontWeights));

    });
    $('.logo_type').on('change', function () {
        if ($(this).val() === 'svg') {
            $('.svg_logo').fadeIn(200);
            $('.img_logo').fadeOut(100);
        } else {
            $('.svg_logo').fadeOut(100);
            $('.img_logo').fadeIn(200);
        }
    });
    $('.alt_logo_type').on('change', function () {
        if ($(this).val() === 'alt_svg') {
            $('.alt_svg_logo').fadeIn(200);
            $('.alt_img_logo').fadeOut(100);
        } else {
            $('.alt_svg_logo').fadeOut(100);
            $('.alt_img_logo').fadeIn(200);
        }
    });


    $('#hip-settings-form').on('submit', function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            method: 'POST',
            url: hipSettings.api.url,
            beforeSend: function (xhr) {
                $('.hip-settings').fadeTo(100, 0.5);
                xhr.setRequestHeader('X-WP-Nonce', hipSettings.api.nonce);
            },
            data: data,
            success: function (r) {
                $('#feedback').fadeIn(100).html('<p class="success">' + hipSettings.strings.saved + '</p>');

            },
            error: function (r) {
                var message = hipSettings.strings.error;
                if (r.hasOwnProperty('message')) {
                    message = r.message;
                }
                $('#feedback').fadeIn(100).html('<p class="failure">' + message + '</p>');
            },
            complete: function () {
                setTimeout(function () {
                    $('#feedback').fadeOut(200);
                }, 2500);
                $('.hip-settings').fadeTo(100, 1);
            }

        });
    });

    $('.upload_logo').on('click', function (e) {
        e.preventDefault();
        var uploadBtn = $(this);
        var media_uploader;
        var imgProperty;
        media_uploader = wp.media({
            frame: "post",
            state: "insert",
            multiple: false
        });
        media_uploader.on("insert", function () {
            imgProperty = media_uploader.state().get("selection").first().toJSON();
            uploadBtn.prev('.site_logo').attr('src', imgProperty.url);
            uploadBtn.next('input').val(imgProperty.url);
        });
        media_uploader.open();
    });



    /**
     *Helper function for formatting font weight value
     */

    var makeOptions = function (list) {
        var options = '', i;
        for (i = 0; i < list.length; i++) {
            options += '<option value="' + formatFontWeight(list[i]) + '">' + list[i] + '</option>'
        }
        return options;
    };

    var formatFontWeight = function (weight) {
        var fw = weight.toLowerCase();
        if (fw === 'regular') {
            return '400';
        }
        else if (fw === 'regular (italic)') {
            return '400i';
        } else if (fw.indexOf('(italic)') !== -1) {
            return fw.replace(' (italic)', 'i');
        } else {
            return fw;
        }
    };

});
