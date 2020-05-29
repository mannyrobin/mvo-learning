<?php

namespace HipCTA\CTA;

class ImageCTA extends CTA
{
    
    protected $meta = [];
    
    public function get_cta_image()
    {
        return $this->get_meta( 'image' );
    }
    
    public function get_link_url()
    {
        return $this->get_meta( 'link_url' );
    }
    
    public function get_meta( $key ) 
    {
        $this->meta = get_post_meta( $this->post_id, 'hipcta', true );
        
        
        if ( array_key_exists( $key, $this->meta ) )
            return $this->meta[$key];
    }
    
    public function set_meta( $meta )
    {
        $this->meta = $meta;
    }
    
    public function render() 
    {
        $html = '<style>.hipcta_image_cta img { height: auto; }</style>';
        $html .= '<a class="hipcta_image_cta" href="'. $this->get_link_url() . '">';
        $html .= wp_get_attachment_image( $this->get_cta_image(), 'large');
        $html .= '</a>';
        
        return $html;
    }
}
