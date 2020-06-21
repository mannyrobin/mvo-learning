<?php 

namespace HipCTA\MetaBoxes;

class PostFlyoutMetaBox
{
    
	protected $container;
	protected $cta;
	protected $mobile_check;
    
	public function __construct( $container )
	{
		$this->container = $container;
		$this->cta = ( get_post_meta( get_the_ID(), 'hipcta_flyout_cta', true ) )
			? get_post_meta( get_the_ID(), 'hipcta_flyout_cta', true ) : '';
		$this->mobile_check = ( get_post_meta( get_the_ID(), 'hipcta_mobile_check', true ) )
			? get_post_meta( get_the_ID(), 'hipcta_mobile_check', true ) : '';
			
	}
	
	public function render()
	{
			$ctas = $this->container['all_cta'];
			$choices = $this->build_choices( $ctas );
			$mobile_check = $this->mobile_check;
			$vars = [
					'choices'       => $choices,
					'none_selected' => ( !empty($this->cta) ) ? false : true,
					'preview'       => $this->get_cta_preview(),
					'mobile_check'  => $mobile_check
			];
			$vars = array_merge( $this->container['template_vars'], $vars );
			
			echo $this->container['twig']->render( 'admin/metaboxes/post_flyout.twig', $vars );
	}
	
	public function build_choices( $ctas )
	{
			$choices = [];
			
			foreach( $ctas as $cta ) {
					$choices[] = [
							'value'     => $cta->ID,
							'label'     => $cta->post_title,
							'selected'  => ( $cta->ID == $this->cta ) ? true : false
					];
			}
			
			return $choices;
	}
	
	public function get_cta_preview()
	{
			if ( ! $this->cta || empty( $this->cta ) || $this->cta == 'false' ) {
					return '';
			} 
			
			$this->container['image_cta']->set_id( $this->cta );
			$image = $this->container['image_cta']->get_cta_image();
			
			return wp_get_attachment_image( $image, 'medium' );
			
	}
	
	public function get_cta_preview_ajax( $data )
	{
			$choice = $data['choice'];
			
			$this->container['image_cta']->set_id($choice);
			$image = $this->container['image_cta']->get_cta_image();
			
			if ( empty( $choice ) ) 
					wp_die();
			
			echo wp_get_attachment_image( $image, 'medium' );
			wp_die();
	}
	
	public function update_post_meta( $post_data )
	{
		if ( ! empty( $post_data['flyout_select'] ) ) {
				if ( $post_data['flyout_select'] == 'false' )
						update_post_meta( get_the_ID(), 'hipcta_flyout_cta', '' );
				else 
						update_post_meta( get_the_ID(), 'hipcta_flyout_cta', $post_data['flyout_select'] );
		}
		update_post_meta( get_the_ID(), 'hipcta_mobile_check', $post_data['mobile_check'] );
	}
}
