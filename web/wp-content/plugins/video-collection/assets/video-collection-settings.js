jQuery(function ($) {
    'use strict';
    $.ajax({
        method: 'GET',
        url: video_collection.api.url,
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', video_collection.api.nonce);
        }
    }).then(function (r) {
        if (r.hasOwnProperty('video_archive_title')) {
            $('#video_archive_title').val(r.video_archive_title);
        }
        if (r.hasOwnProperty('video_archive_slug')) {
            $('#video_archive_slug').val(r.video_archive_slug);
        }
        if (r.hasOwnProperty('video_play_btn_color')) {
            $('#video_play_btn_color').val(r.video_play_btn_color);
        }
        if (r.hasOwnProperty('video_play_btn_hover_color')) {
            $('#video_play_btn_hover_color').val(r.video_play_btn_hover_color);
        }
        if (r.hasOwnProperty('video_play_btn_bg_color')) {
            $('#video_play_btn_bg_color').val(r.video_play_btn_bg_color);
        }
        if (r.hasOwnProperty('video_play_btn_hover_bg_color')) {
            $('#video_play_btn_hover_bg_color').val(r.video_play_btn_hover_bg_color);
        }
        if (r.hasOwnProperty('play_defalut_style')) {
            $('#play_defalut_style').prop('checked', true);
        }
    });

    $('#hip-video-collection-form').on('submit', function (e) {
        e.preventDefault();

        var data = $(this).serializeArray();
        $.ajax({
            method: 'POST',
            url: video_collection.api.url,
            beforeSend: function (xhr) {
                $('.video-settings').fadeTo(100, 0.5);
                xhr.setRequestHeader('X-WP-Nonce', video_collection.api.nonce);
            },
            data: data,
            success: function (r) {
                $('#feedback').fadeIn(100).html('<p class="success">' + video_collection.strings.saved + '</p>');
            },
            error: function (r) {
                var message = video_collection.strings.error;
                if (r.hasOwnProperty('message')) {
                    message = r.message;
                }
                $('#feedback').fadeIn(100).html('<p class="failure">' + message + '</p>');
            },
            complete: function () {
                setTimeout(function () {
                    $('#feedback').fadeOut(200);
                }, 2500);
                $('.video-settings').fadeTo(100, 1);
            }
        });
    });
});
