
jQuery(function($) {
  var flyout = $('#hipcta_flyout');
  if (flyout.length>0) {
    $(window).scroll(function(){
        if ( $(document).scrollTop() === 0 ) {
            flyout.removeClass('is_active');
        } else {
            if(!(flyout.hasClass('closed'))){
	            flyout.addClass('is_active');
            }
        }
    });
    $('.close-cta').on('click',function(){
	    flyout.removeClass('is_active').addClass('closed');
    });
  }
});
