(function ($) {
    $(document).ready(function () {
        var showTitleCheckbox = $('#show_title');
        var insertShortcodeBtn = $('.insert-video-shortcode');
        if(showTitleCheckbox.length){
            $(showTitleCheckbox).on('change',function(){
                if($(this).prop('checked')){
                    $('.insert-video-form .hidden').fadeIn('200');
                }else{
                    $('.insert-video-form .hidden').fadeOut('150');
                }
            })
        }
        if(insertShortcodeBtn.length){
            insertShortcodeBtn.on('click',function(){
                var video = $('#video_name'),
                    videoId = video.val(),
                    showTitle=titlePos=shortCode='';
                shortCode +='[hip_video ';
                shortCode += 'id='+videoId+' ';
                if(showTitleCheckbox.prop('checked')){
                    showTitle = 1;
                    titlePos = 'title_pos='+$('#title_pos').val();
                    shortCode +='show_title='+showTitle+' '+titlePos;
                }else{
                    showTitle = 0;
                    shortCode +='show_title='+showTitle;
                }
                shortCode += ']';
                window.send_to_editor(shortCode);
                showTitleCheckbox.prop('checked', false);
                video.val('0');
                $('.insert-video-form .hidden').hide();
            })
        }

    });
})(jQuery);