<?php

namespace HipCTA\MetaBoxes;

class ImageCTAMetaBox
{
    protected $cta;
    protected $container;
    
    public function __construct( $cta )
    {
        $this->cta = $cta;
        $this->container = $cta->get_container();
    }
    
    public function render()
    {
        $image_id = $this->cta->get_cta_image();
        $image_html = ( !empty( $image_id ) ) ? wp_get_attachment_image( $image_id, 'large' ) : '';
        
        $vars = array_merge( $this->container['template_vars'], [
            'image_html'    => $image_html,
            'link_url'      => $this->cta->get_link_url(),
            'image_id'      => $image_id
        ] );
        
        echo $this->container['twig']->render( 'admin/metaboxes/image_cta.twig', $vars );
    }
    
    public function update_post_meta( $post_data )
    {
        $is_autosave = wp_is_post_autosave( $this->cta->get_id() );
        $is_revision = wp_is_post_revision( $this->cta->get_id() );
        
        if ( $is_autosave || $is_revision )
            return;
        
        if ( !empty( $post_data['hipcta'] ) ) {
            update_post_meta( $this->cta->get_id(), 'hipcta', $post_data['hipcta'] );
        }
    }
}
