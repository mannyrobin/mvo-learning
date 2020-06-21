<?php 

namespace HipCTA;

class PostFlyout
{
    protected $container;
    protected $post_id;
    protected $cta_settings;
    public function __construct( $container )
    {
        $this->container = $container;
		$this->cta_settings = \HipCTA\Settings::getSettings();
    }
    
    public function set_post_id( $id )
    {
        $this->post_id = $id;
    }
    
    public function render()
    {
        $image = $this->get_image();
        $link = $this->get_link();
        if ( ! $image ) 
            return false;
        if($this->cta_settings['hide_cta_on_mobile'] == 'on'){
        	$mobile_check = $this->cta_settings['hide_cta_on_mobile'];
		}else{
        	if(get_post_meta( $this->post_id, 'hipcta_mobile_check', true ) == 'on'){
				$mobile_check = get_post_meta( $this->post_id, 'hipcta_mobile_check', true );
			}else{
        		$mobile_check = '';
			}
		}
		if(!empty($this->cta_settings['mobile_width'])){
        	$mobile_width = $this->cta_settings['mobile_width'] - 1;
		}else{
        	$mobile_width = 480;
		}
        $vars = array_merge( $this->container['template_vars'], [ 
            'image' => $image,
            'link'  => $link,
			'mobile_check' => $mobile_check,
			'mobile_width' => $mobile_width
        ] );
        
        echo $this->container['twig']->render( 'post_flyout.twig', $vars );
    }
	
    
    public function get_image() {
        $id = get_post_meta( $this->post_id, 'hipcta_flyout_cta', true );
        if ( !empty( $id ) ) {
        
            $this->container['image_cta']->set_id( $id );
            $image = $this->container['image_cta']->get_cta_image();
            if ( $image && !empty( $image ) ) {
                return wp_get_attachment_image( $image, 'full' );
            }
        }
        
        return false;
    }
    
    public function get_link() {
        $id = get_post_meta( $this->post_id, 'hipcta_flyout_cta', true );

        if ( !empty( $id ) ) {
        
            $this->container['image_cta']->set_id( $id );
            return $this->container['image_cta']->get_link_url();

        }
        return false;
    }
}
