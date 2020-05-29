( function($) {
    $(document).ready( function () {
        
        $( "select[name='flyout_select']").change( function(e) {
            
            var data = {
                'action': 'flyout_admin',
                'choice': $(this).find('option:selected').val()
            }
            
            $.post( ajaxurl, data, function( response ) {
                $('#flyout_preview').html( response );
            });
        });
    });
})(jQuery);
