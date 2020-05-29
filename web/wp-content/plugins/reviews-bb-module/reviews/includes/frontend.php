<div class="review-module-container">
    <div class="review-module-column">
        <a class="positive-review-link popup" href="#positive-review-popup">
            <img id="positive-review" class="review-image" width="130" height="130"
                src="<?php echo $module->url ?>/includes/images/greensmile.png"
                alt="smile" data-pin-no-hover="true">
            <span class="under-image">I had a good experience.</span>
        </a>
    </div>
    
    <div class="review-module-column">
        <a class="negative-review-link popup" href="#negative-review-popup">
            <img id="negative-review" class="review-image" width="130" height="130"
                src="<?php echo $module->url ?>/includes/images/redfrown.png"
                alt="frown" data-pin-no-hover="true">
            <span class="under-image">I had a bad experience.</span>
        </a>
    </div>
</div>

<div id="positive-review-popup" class="review-lightbox ">
    <?php include( $module->dir . '/includes/positive-popup.php' ); ?>
</div>

<div id="negative-review-popup" class="review-lightbox">
    <?php include( $module->dir . '/includes/negative-popup.php' ); ?>
</div>

<?php foreach( $settings->review_site as $key => $site  ): ?>
<div id="<?php echo 'instructions-'.$key ?>" class="instruction_popup">
    <div class="instruct_header">
        <?php echo wp_get_attachment_image( $site->logo, 'full' ); ?>
    </div>
    
    <div class="instruct_body">
        <?php echo $site->instruction; ?>
    </div>
    
    <div class="instruct_footer">
        <a class="instruct_button" href="<?php echo $site->url ?>">Review Us</a>
    </div>
</div>
<?php endforeach; ?>

    
<script type="text/javascript">
jQuery(document).ready( function($) {

    $('a.popup').popup({
        show : function(){
            var windowTop = $(window).scrollTop();
            $('.popup_cont').css({'opacity': 1});
            if($(window).width() < 768){
                $('.popup_cont').css({
                    'top': windowTop + 20
                });
            }else{
                $('.popup_cont').css({
                    'top': Math.abs(windowTop + ((($(window).height()) - ($('.popup_cont').height())) / 2))
                });
            }
            $(window).on('resize',function(){
                if($(window).width() < 768){
                    $('.popup_cont').css({
                        'top': windowTop + 20
                    });
                }else{
                    $('.popup_cont').css({
                        'top': Math.abs(windowTop + ((($(window).height()) - ($('.popup_cont').height())) / 2))
                    });
                }
            })
        },
        replaced : function(){
            var windowTop = $(window).scrollTop();
            $('.popup_cont').css({'opacity': 1});
            if($(window).width() < 768){
                $('.popup_cont').css({
                    'top': windowTop + 20
                });
            }else{
                $('.popup_cont').css({
                    'top': Math.abs(windowTop + ((($(window).height()) - ($('.popup_cont').height())) / 2))
                });
            }
            $(window).on('resize',function(){
                if($(window).width() < 768){
                    $('.popup_cont').css({
                        'top': windowTop + 20
                    });
                }else{
                    $('.popup_cont').css({
                        'top': Math.abs(windowTop + ((($(window).height()) - ($('.popup_cont').height())) / 2))
                    });
                }
            })
        }
    });
});
</script>
