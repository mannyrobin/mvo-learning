(function ($) {
    $(document).ready(function () {

        var Input_youtubeUrl = '#_pvc_video_embed';

        function validUrl(youtube_url) {
            var regex = /^(https\:\/\/)(youtu\.\.?be)\/[^\s]+$/;
            return regex.test(youtube_url.trim());
        }

        $(Input_youtubeUrl).focusout(function () {
            var valid_url = validUrl($(this).val());
            if (valid_url) {
                $('.validation-txt').css({'display': 'none'});
            } else {
                $('.validation-txt').html('✘ Invalid Youtube Share url').css({'color': 'red', 'display': 'block'});
            }
        });

        if ($(Input_youtubeUrl).length > 0) {
            $('#publish').on('click', function () {
                if (!validUrl($(Input_youtubeUrl).val())) {
                    $('.validation-txt').html('✘ Invalid Youtube Share url').css({'color': 'red', 'display': 'block'});
                    return false;
                }
            });
        }

        $('.pvc_image_button[name="pvc_remove_image"]').click(function (e) {
            e.preventDefault();
            removeImage();
        });
        $('.pvc_image_button[name="pvc_replace_image"]').click(function (e) {
            e.preventDefault();
            mediaModal();
        });
        $('.pvc_image_button[name="pvc_upload_image"]').click(function (e) {
            e.preventDefault();
            mediaModal();
        });

        var mediaModal = function () {
            var media_modal = wp.media({
                frame: 'select',
                multiple: false,
                editing: true,
                title: 'Add a screenshot',
                library: {type: 'image'}
            });

            media_modal.on('select', function () {
                var media = media_modal.state().get('selection').first().toJSON();
                renderPreview(media);
            });

            var renderPreview = function (media) {
                var imgHtml = '<img src="' + media.url + '" '
                    + 'width="300" height="auto" '
                    + 'class="pvc_admin_image">';

                if ($('.pvc_image_placeholder').length)
                    $('.pvc_image_placeholder').replaceWith(imgHtml);
                else
                    $('.pvc_admin_image').replaceWith(imgHtml);

                $('input[name="_pvc_screenshot"]').val(media.id);
            };

            media_modal.open();
            return false;
        };

        var removeImage = function () {
            $('.pvc_admin_image').replaceWith('<div class="pvc_image_placeholder">No Image Selected.</div>');
            $('input[name="_pvc_screenshot"]').val('');
        };
    });
})(jQuery);
