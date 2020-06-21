(function($) {
    
    $(document).ready( function() {
               
        $('body').on( 'click', '#upload_cta_image', function() {
            HipCTAImage.upload( $('#hipcta_img_preview') );
        } );
        
        $('body').on( 'click', 'a#remove_cta_image', function(event) {
            event.preventDefault();
            HipCTAImage.clear( $(this).parent() );
        } );
    } );
    
    HipCTAImage = {};
    
    HipCTAImage.upload = function ( parent_el )
    {
				var frame;
				
				if ( frame ) {
					frame.open();
					return;
				}
        
        frame = wp.media({
            title: "Upload Image",
            multiple: false,
            library: { type: 'image' },
            button: { text: 'Select' }
        } );
        
        frame.on( 'close', function() {
            var attachment = frame.state().get('selection').toJSON();
            HipCTAImage.drawPreview( parent_el, attachment[0] );
        } );
        
        frame.open();
    };
    
    HipCTAImage.clear = function ( parent_el )
    {
        $(parent_el).html( '<input id="upload_cta_image" type="button" class="button button-large" value="Upload Image"/>' );
        $('#cta_image_id').val('');
    };
    
    HipCTAImage.drawPreview = function ( parent_el, attachment )
    {
        if ( $(parent_el).children( 'img' ).length === 0 ) {
            HipCTAImage.clear( parent_el );
        }
        
        $('#cta_image_id').val( attachment.id ); 
        
        var img_html = '<img src="' + attachment.url + '" width="250px" height="auto" alt="Preview Image">';
        
        img_html += '<a class="remove_slide_image" href="#">Remove Slide Image</a>';
        
        $('#hipcta_img_preview').html(img_html);
    };
    
})(jQuery);
