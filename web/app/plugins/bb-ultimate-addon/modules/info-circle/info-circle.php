<?php


/**
 * @class UABBInfoCircleModule
 */
class UABBInfoCircleModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __( 'Info Circle', 'uabb' ),
			'description'   	=> __( 'Display a info circle.', 'uabb' ),
			'category'      	=> UABB_CAT,
			'dir'           	=> BB_ULTIMATE_ADDON_DIR . 'modules/info-circle/',
            'url'           	=> BB_ULTIMATE_ADDON_URL . 'modules/info-circle/',
            'partial_refresh'	=> false
		));

		$this->add_css( 'uabb-animate', BB_ULTIMATE_ADDON_URL . 'assets/css/uabb-animate.css' );
	}

	/* Render Icon/Photo */
	function render_icon_image( $item, $active = '' ) {
		$photo_source = $item->photo_source;
		$photo = $item->photo;
		$photo_url = $item->photo_url;
		$photo_src = ( isset( $item->photo_src ) ) ? $item->photo_src : '';

		if( $active == 'active-img' && $item->photo_active_type == 'change-img' ) {
			$photo_source = $item->active_photo_source;
			$photo = $item->active_photo;
			$photo_url = $item->active_photo_url;
			$photo_src = ( isset( $item->active_photo_src ) ) ? $item->active_photo_src : '';
		}

		$imageicon_array = array(
			/* General Section */
			'image_type' => $item->image_type,
			
			/* Icon Basics */
			'icon' => $item->icon,
			'icon_align' => "center",
			
			/* Image Basics */
			'photo_source' => $photo_source,
			'photo' => $photo,
			'photo_url' => $photo_url,
			'img_align' => "center",
			// 'img_bg_size'  => $settings->thumb_custom_bg_size,
			'image_style' => $this->settings->thumb_style,
			'photo_src' =>  $photo_src,
		); 
		/* Render HTML Function */
		FLBuilder::render_module_html( 'image-icon', $imageicon_array );
	}

	/**
	 * @method render_button
	 */
	function render_cta( $item ) {

		if( $item->desc_cta_type == 'button' ) {
			
			$btn_settings = array(

				/* General Section */
				'text'              => $item->cta_text,

				/* Link Section */
				'link'              => $item->cta_link,
				'link_target'       => $item->cta_link_target,

				/* Style Section */
				'style'             => $item->btn_style,
				'border_size'       => $item->btn_border_size,
				'transparent_button_options' => $item->btn_transparent_button_options,
				'threed_button_options'      => $item->btn_threed_button_options,
				'flat_button_options'        => $item->btn_flat_button_options,

				/* Colors */
				'bg_color'          => $item->btn_bg_color,
				'bg_hover_color'    => $item->btn_bg_hover_color,
				'text_color'        => $item->btn_text_color,
				'text_hover_color'  => $item->btn_text_hover_color,
				'hover_attribute'	=> $item->hover_attribute,

				/* Icon */
				'icon'              => $item->btn_icon,
				'icon_position'     => $item->btn_icon_position,

				/* Structure */
				'width'              => $item->btn_width,
				'custom_width'       => $item->btn_custom_width,
				'custom_height'      => $item->btn_custom_height,
				'padding_top_bottom' => $item->btn_padding_top_bottom,
				'padding_left_right' => $item->btn_padding_left_right,
				'border_radius'      => $item->btn_border_radius,
				'align'              => 'center',
				'mob_align'          => 'center',

				/* Typography */
				'font_size'         => $item->btn_font_size,
				'line_height'       => $item->btn_line_height,
				'font_family'       => $item->btn_font_family,
			);

			FLBuilder::render_module_html( 'uabb-button', $btn_settings );
		} else {
			echo '<a href="'. $item->cta_link .'" target="'. $item->cta_link_target .'" class="uabb-infoc-link" >'. $item->cta_text .'</a>';
		}
	}
}

/**
 * Get Responsive Breakpoint from Global Setting
 */
$default_breakpoint = ( trim(UABB_Model_Helper::$bb_global_settings->medium_breakpoint) != '' ) ? UABB_Model_Helper::$bb_global_settings->medium_breakpoint : '';
/*$notice = __( 'Info Circle is the element where all the items (icons/images) are placed at the edge of the circle & content is displayed inside the circle. The content of each item will be displayed on the hover or click event of an item.' , 'uabb' );*/

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('UABBInfoCircleModule', array(
	'info_circle_item' => array(
		'title'			=> __( 'Info Circle Items', 'uabb' ),
		'sections'		=> array(
			'info_circle_general' => array(
				'title'		=> '',
				'fields'	=> array(
					/*'info_circle_info' => array(
						'type'     => 'uabb-msgbox',
						'label'    => '',
						'msg-type' => 'info',
						'content'  => $notice,
					),*/
					'add_circle_item' => array(
						'type'			=> 'form',
						'label'			=> __( 'Info Circle Item', 'uabb' ),
						'form'			=> 'info_circle_items_form',
						'preview_text'	=> 'circle_item_title',
						'multiple'		=> true
					),
				)
			)
		)
	),
	'general'	=> array(
		'title'		=> __( 'General', 'uabb' ),
		'sections'	=> array(
			'general'	=> array(
				'title'		=> __( 'General', 'uabb' ),
				'fields'	=> array(
					'autoplay'     => array(
						'type'          => 'uabb-toggle-switch',
						'label'         => __( 'Autoplay', 'uabb' ),
						'default'       => 'yes',
						'options'       => array(
							'yes'		=> __( 'Yes', 'uabb' ),
							'no'		=> __( 'No', 'uabb' ),
						),
						'toggle'	=> array(
							'yes'		=> array(
								'fields'	=> array( 'autoplay_time' ),
							)
						),
						'help'	=> __( 'Auto navigate from one info circle item to another. It will rotate the inside content as well.', 'uabb' ),
					),
					'autoplay_time' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Autoplay Interval', 'uabb' ),
						'placeholder'	=> '15',
						'size'			=> '5',
						'description'	=> 'sec(s)',
					),
					'content_width'     => array(
						'type'          => 'uabb-toggle-switch',
						'label'         => __( 'Content Area Width', 'uabb' ),
						'default'       => 'custom',
						'options'       => array(
							'full'		=> __( 'Full', 'uabb' ),
							'custom'	=> __( 'Custom', 'uabb' ),
						),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array( 'inner_area_size' ),
								'sections'	=> array( 'outer_background' ),
							)
						),
						'help'	=> __( 'Controls the width of inside content area. Select full, if you wish to cover all entire inside area to display content.', 'uabb'),
					),
					'inner_area_size' => array(
						'type'		=> 'text',
						'label'		=> __( 'Custom Content Width', 'uabb' ),
						'placeholder' => '80',
						'size'		  => '5',
						'description' => '%',
						'help'	=> __( 'Enter the width of your content area. This is proportionate with overall Info Circle area.', 'uabb' ),
					),
					'info_trigger_type'     => array(
						'type'          => 'uabb-toggle-switch',
						'label'         => __( 'Action to Display Content', 'uabb' ),
						'default'       => 'hover',
						'options'       => array(
							'hover'		=> __( 'Hover', 'uabb' ),
							'click'		=> __( 'Click', 'uabb' ),
						),
						'help'	=> __( 'Select the action to display info circle\'s individual item\'s content inside the content area.', 'uabb' ),
					),
					'responsive_nature'     => array(
						'type'          => 'uabb-toggle-switch',
						'label'         => __( 'Responsive Fallback Structure', 'uabb' ),
						'default'       => 'true',
						'options'       => array(
							'true'		=> __( 'Enable', 'uabb' ),
							'false'		=> __( 'Disable', 'uabb' ),
						),
						'toggle'	=> array(
							'true'		=> array(
								'fields'	=> array( 'breakpoint', 'thumbnail_size_mobile' )
							)
						),
						'help'	=> __( 'Enable this if your module does not look good on responsive devices. This will convert Info Circle to normal Info Box element.', 'uabb' ),
					),
					'breakpoint' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Breakpoint For Fallback Structure', 'uabb' ),
						'default'		=> '',
						'placeholder'	=> $default_breakpoint,
						'size'			=> '5',
						'description'	=> 'px',
						'help'			=> __( 'Below this breakpoint, Info Circle will convert to a responsive structure.', 'uabb' ),
					),
				)
			),
		)
	),
	'style'         => array(
		'title'         => __( 'Style', 'uabb' ),
		'sections'      => array(
			'thumbnails'	=> array(
				'title'         => __( 'Thumbnail', 'uabb' ),
				'fields'        => array(
					'first_thumb_pos' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Position of First Thumbnail', 'uabb' ),
						'placeholder'	=> '0',
						'size'			=> '5',
						'description'	=> 'deg',
						'help'			=> __( 'The degree from where Info Circle will be displayed.', 'uabb' )
					),
					'thumbnail_size'	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Thumbnail Icon/Image Size', 'uabb' ),
						'placeholder'	=> '80',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'thumbnail_size_mobile'	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Responsive Icon/image Size', 'uabb' ),
						'placeholder'	=> '60',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'active_animation'	=> array(
						'type'          => 'select',
						'label'         => __( 'Animation of Active Thumbnail', 'uabb' ),
						'default'       => 'no',
						'options'       => array(
							'no'				=> __( 'No', 'uabb' ),
							'bounce'			=> __( 'bounce' , 'uabb' ),
							'flash'				=> __( 'flash' , 'uabb' ),
							'pulse'				=> __( 'pulse' , 'uabb' ),
							'rubberBand'		=> __( 'rubberBand' , 'uabb' ),
							'shake'				=> __( 'shake' , 'uabb' ),
							'headShake'		 	=> __( 'headShake' , 'uabb' ),
							'swing'				=> __( 'swing' , 'uabb' ),
							'tada'				=> __( 'tada' , 'uabb' ),
							'wobble'			=> __( 'wobble' , 'uabb' ),
							'jello'				=> __( 'jello' , 'uabb' ),
							'bounceIn'			=> __( 'bounceIn' , 'uabb' ),
							'bounceInDown'	 	=> __( 'bounceInDown' , 'uabb' ),
							'bounceInLeft'	 	=> __( 'bounceInLeft' , 'uabb' ),
							'bounceInRight'	 	=> __( 'bounceInRight' , 'uabb' ),
							'bounceInUp'	 	=> __( 'bounceInUp' , 'uabb' ),
							'fadeIn'			=> __( 'fadeIn' , 'uabb' ),
							'fadeInDown'	 	=> __( 'fadeInDown' , 'uabb' ),
							'fadeInDownBig'	 	=> __( 'fadeInDownBig' , 'uabb' ),
							'fadeInLeft'		=> __( 'fadeInLeft' , 'uabb' ),
							'fadeInLeftBig'		=> __( 'fadeInLeftBig' , 'uabb' ),
							'fadeInRight'		=> __( 'fadeInRight' , 'uabb' ),
							'fadeInRightBig'	=> __( 'fadeInRightBig' , 'uabb' ),
							'fadeInUp'			=> __( 'fadeInUp' , 'uabb' ),
							'fadeInUpBig'		=> __( 'fadeInUpBig' , 'uabb' ),
							'flipInX'			=> __( 'flipInX' , 'uabb' ),
							'flipInY'			=> __( 'flipInY' , 'uabb' ),
							'flipOutX'			=> __( 'flipOutX' , 'uabb' ),
							'flipOutY'			=> __( 'flipOutY' , 'uabb' ),
							'lightSpeedIn'		=> __( 'lightSpeedIn' , 'uabb' ),
							'rotateIn'			=> __( 'rotateIn' , 'uabb' ),
							'rotateInDownLeft'	=> __( 'rotateInDownLeft' , 'uabb' ),
							'rotateInDownRight'	=> __( 'rotateInDownRight' , 'uabb' ),
							'rotateInUpLeft'	=> __( 'rotateInUpLeft' , 'uabb' ),
							'rotateInUpRight'	=> __( 'rotateInUpRight' , 'uabb' ),
							'rollIn'			=> __( 'rollIn' , 'uabb' ),
							'zoomIn'			=> __( 'zoomIn' , 'uabb' ),
							'zoomInDown'		=> __( 'zoomInDown' , 'uabb' ),
							'zoomInLeft'		=> __( 'zoomInLeft' , 'uabb' ),
							'zoomInRight'		=> __( 'zoomInRight' , 'uabb' ),
							'zoomInUp'			=> __( 'zoomInUp' , 'uabb' ),
							'slideInDown'		=> __( 'slideInDown' , 'uabb' ),
							'slideInLeft'		=> __( 'slideInLeft' , 'uabb' ),
							'slideInRight'		=> __( 'slideInRight' , 'uabb' ),
							'slideInUp'			=> __( 'slideInUp' , 'uabb' ),
						),
					),
					'initial_animation'	=> array(
						'type'          => 'select',
						'label'         => __( 'Animation of Thumbnails when Page Loads', 'uabb' ),
						'default'       => 'bounceIn',
						'options'       => array(
							'no'				=> __( 'No', 'uabb' ),
							'bounce'			=> __( 'bounce' , 'uabb' ),
							'flash'				=> __( 'flash' , 'uabb' ),
							'pulse'				=> __( 'pulse' , 'uabb' ),
							'rubberBand'		=> __( 'rubberBand' , 'uabb' ),
							'shake'				=> __( 'shake' , 'uabb' ),
							'headShake'		 	=> __( 'headShake' , 'uabb' ),
							'swing'				=> __( 'swing' , 'uabb' ),
							'tada'				=> __( 'tada' , 'uabb' ),
							'wobble'			=> __( 'wobble' , 'uabb' ),
							'jello'				=> __( 'jello' , 'uabb' ),
							'bounceIn'			=> __( 'bounceIn' , 'uabb' ),
							'bounceInDown'	 	=> __( 'bounceInDown' , 'uabb' ),
							'bounceInLeft'	 	=> __( 'bounceInLeft' , 'uabb' ),
							'bounceInRight'	 	=> __( 'bounceInRight' , 'uabb' ),
							'bounceInUp'	 	=> __( 'bounceInUp' , 'uabb' ),
							'fadeIn'			=> __( 'fadeIn' , 'uabb' ),
							'fadeInDown'	 	=> __( 'fadeInDown' , 'uabb' ),
							'fadeInDownBig'	 	=> __( 'fadeInDownBig' , 'uabb' ),
							'fadeInLeft'		=> __( 'fadeInLeft' , 'uabb' ),
							'fadeInLeftBig'		=> __( 'fadeInLeftBig' , 'uabb' ),
							'fadeInRight'		=> __( 'fadeInRight' , 'uabb' ),
							'fadeInRightBig'	=> __( 'fadeInRightBig' , 'uabb' ),
							'fadeInUp'			=> __( 'fadeInUp' , 'uabb' ),
							'fadeInUpBig'		=> __( 'fadeInUpBig' , 'uabb' ),
							'flipInX'			=> __( 'flipInX' , 'uabb' ),
							'flipInY'			=> __( 'flipInY' , 'uabb' ),
							'flipOutX'			=> __( 'flipOutX' , 'uabb' ),
							'flipOutY'			=> __( 'flipOutY' , 'uabb' ),
							'lightSpeedIn'		=> __( 'lightSpeedIn' , 'uabb' ),
							'rotateIn'			=> __( 'rotateIn' , 'uabb' ),
							'rotateInDownLeft'	=> __( 'rotateInDownLeft' , 'uabb' ),
							'rotateInDownRight'	=> __( 'rotateInDownRight' , 'uabb' ),
							'rotateInUpLeft'	=> __( 'rotateInUpLeft' , 'uabb' ),
							'rotateInUpRight'	=> __( 'rotateInUpRight' , 'uabb' ),
							'rollIn'			=> __( 'rollIn' , 'uabb' ),
							'zoomIn'			=> __( 'zoomIn' , 'uabb' ),
							'zoomInDown'		=> __( 'zoomInDown' , 'uabb' ),
							'zoomInLeft'		=> __( 'zoomInLeft' , 'uabb' ),
							'zoomInRight'		=> __( 'zoomInRight' , 'uabb' ),
							'zoomInUp'			=> __( 'zoomInUp' , 'uabb' ),
							'slideInDown'		=> __( 'slideInDown' , 'uabb' ),
							'slideInLeft'		=> __( 'slideInLeft' , 'uabb' ),
							'slideInRight'		=> __( 'slideInRight' , 'uabb' ),
							'slideInUp'			=> __( 'slideInUp' , 'uabb' ),
						),
					),
				)
			),
			'thumb_styles' => array( // Section
				'title'		=> __( 'Thumbnail Styles', 'uabb' ), // Section Title
				'fields'	=> array( // Section Fields
					'thumb_style' => array(
						'type'          => 'select',
						'label'         => __( 'Thumbnail Style', 'uabb' ),
						'default'       => 'circle',
						'options'       => array(
							'circle'		=> __( 'Circle', 'uabb' ),
							'square'		=> __( 'Square', 'uabb' ),
							'custom'		=> __( 'Custom', 'uabb' ),
						),
						'toggle'	=> array(
							'custom'	=> array(
								'fields'	=> array( 'thumb_custom_radius' )
							),
						),
					),
					'thumb_custom_radius' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Custom Radius', 'uabb' ),
						'placeholder'	=> '0',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'thumb_border_style' => array(
						'type'          => 'select',
						'label'         => __( 'Border Style', 'uabb' ),
						'default'       => 'none',
						'options'       => array(
							'none'			=> __( 'None', 'uabb' ),
							'solid'			=> __( 'Solid', 'uabb' ),
							'dashed'		=> __( 'Dashed', 'uabb' ),
							'dotted'		=> __( 'Dotted', 'uabb' ),
							'double'		=> __( 'Double', 'uabb' ),
						),
						'toggle'	=> array(
							'solid'		=> array(
								'fields'	=> array( 'thumb_border_width', 'thumb_border_color', 'thumb_active_border_color' )
							),
							'dashed'	=> array(
								'fields'	=> array( 'thumb_border_width', 'thumb_border_color', 'thumb_active_border_color' )
							),
							'dotted'	=> array(
								'fields'	=> array( 'thumb_border_width', 'thumb_border_color', 'thumb_active_border_color' )
							),
							'double'	=> array(
								'fields'	=> array( 'thumb_border_width', 'thumb_border_color', 'thumb_active_border_color' )
							)
						),
					),
					'thumb_border_width' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Border Thickness', 'uabb' ),
						'placeholder'	=> '1',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'thumb_border_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Border Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
					),
					'thumb_active_border_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Active Border Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
					),
				)
			),
			'information_area'	=> array(
				'title'         => __( 'Information Area', 'uabb' ),
				'fields'        => array(
					'info_area_spacing'		=> array(
						'type'          => 'uabb-spacing',
                        'label'         => __( 'Content Padding', 'uabb' ),
                        'mode'			=> 'padding',
                        'help'			=> __( 'To give padding to Information Area use this setting', 'uabb' ),
                        'default'       => 'padding: 25px;' // Optional
					),
					'info_area_icon'     => array(
						'type'          => 'select',
						'label'         => __( 'Info Icon/Image', 'uabb' ),
						'default'       => 'no',
						'options'       => array(
							'no'			=> __('Disable','uabb'),
							'simple'		=> __('Simple','uabb'),
							'custom'		=> __('Custom','uabb'),
						),
						'toggle'	=> array(
							'simple'		=> array(
								'fields'	=> array( 'icon_img_size', 'icon_img_color' ),
								'sections'	=> array( 'information_area_icon' )
							),
							'custom'		=> array(
								'fields'	=> array( 'icon_img_size', 'icon_img_color', 'icon_img_bg_padding', 'icon_img_border_radius', 'icon_img_bg_color', 'info_icon_img_border_style' ),
								'sections'	=> array( 'information_area_icon' )
							),
						),
					),
					'info_bg_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Background Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
						'help'		 => __( 'Use this color only when you want same color for Information Area and for unique color use Info Circle Items', 'uabb' ),
					),
					'info_bg_color_opc' => array( 
						'type'        => 'text',
						'label'		  => __( 'Background Color Opacity', 'uabb' ),
						'default'     => '',
						'description' => '%',
						'maxlength'   => '3',
						'size'        => '5',
					),
				)
			),
			'information_area_icon'	=> array(
				'title'         => __( 'Information Area Icon/Image', 'uabb' ),
				'fields'        => array(
					'icon_img_size' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Icon/Image Size', 'uabb' ),
						'placeholder'	=> '60',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'icon_img_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Icon Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
					),
					'icon_img_bg_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Icon/Image Background Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
					),
					'icon_img_bg_padding' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Icon/Image Background Size', 'uabb' ),
						'placeholder'	=> '0',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'icon_img_border_radius' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Icon/Image Border Radius', 'uabb' ),
						'placeholder'	=> '0',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'info_icon_img_border_style' => array(
							'type'          => 'select',
							'label'         => __( 'Icon/Image Border Style', 'uabb' ),
							'default'       => 'none',
							'options'       => array(
								'none'			=> __( 'None', 'uabb' ),
								'solid'			=> __( 'Solid', 'uabb' ),
								'dashed'		=> __( 'Dashed', 'uabb' ),
								'dotted'		=> __( 'Dotted', 'uabb' ),
								'double'		=> __( 'Double', 'uabb' ),
							),
							'toggle'	=> array(
								'solid'		=> array(
									'fields'	=> array( 'info_icon_img_border_width', 'info_icon_img_border_color' )
								),
								'dashed'	=> array(
									'fields'	=> array( 'info_icon_img_border_width', 'info_icon_img_border_color' )
								),
								'dotted'	=> array(
									'fields'	=> array( 'info_icon_img_border_width', 'info_icon_img_border_color' )
								),
								'double'	=> array(
									'fields'	=> array( 'info_icon_img_border_width', 'info_icon_img_border_color' )
								)
							),
					),
					'info_icon_img_border_width' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Icon/Image Border Thickness', 'uabb' ),
						'placeholder'	=> '1',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'info_icon_img_border_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Icon/Image Border Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
					),
				)
			),
			'separator'	=> array(
				'title'         => __( 'Separator', 'uabb' ),
				'fields'        => array(
					'info_separator_style' => array(
							'type'          => 'select',
							'label'         => __( 'Separator Style', 'uabb' ),
							'default'       => 'none',
							'options'       => array(
								'none'			=> __( 'None', 'uabb' ),
								'solid'			=> __( 'Solid', 'uabb' ),
								'dashed'		=> __( 'Dashed', 'uabb' ),
								'dotted'		=> __( 'Dotted', 'uabb' ),
								'double'		=> __( 'Double', 'uabb' ),
							),
							'toggle'	=> array(
								'solid'		=> array(
									'fields'	=> array( 'info_separator_width', 'info_separator_height', 'info_separator_color', 'info_separator_margin_top', 'info_separator_margin_bottom' )
								),
								'dashed'	=> array(
									'fields'	=> array( 'info_separator_width', 'info_separator_height', 'info_separator_color', 'info_separator_margin_top', 'info_separator_margin_bottom' )
								),
								'dotted'	=> array(
									'fields'	=> array( 'info_separator_width', 'info_separator_height', 'info_separator_color', 'info_separator_margin_top', 'info_separator_margin_bottom' )
								),
								'double'	=> array(
									'fields'	=> array( 'info_separator_width', 'info_separator_height', 'info_separator_color', 'info_separator_margin_top', 'info_separator_margin_bottom' )
								)
							),
					),
					'info_separator_height' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Separator Thickness', 'uabb' ),
						'placeholder'	=> '3',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'info_separator_width' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Separator Width', 'uabb' ),
						'placeholder'	=> '12',
						'size'			=> '5',
						'description'	=> '%',
					),
					'info_separator_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Separator Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
						'help'	     => __( 'For same color use this option and to give unique color use Info Circle Items.', 'uabb' ),
					),
				)
			),
			'connector'	=> array(
				'title'         => __( 'Connector', 'uabb' ),
				'fields'        => array(
					'connector_border_style' => array(
							'type'          => 'select',
							'label'         => __( 'Line Style', 'uabb' ),
							'default'       => 'solid',
							'options'       => array(
								'none'			=> __( 'None', 'uabb' ),
								'solid'			=> __( 'Solid', 'uabb' ),
								'dashed'		=> __( 'Dashed', 'uabb' ),
								'dotted'		=> __( 'Dotted', 'uabb' ),
								'double'		=> __( 'Double', 'uabb' ),
							),
							'toggle'	=> array(
								'solid'		=> array(
									'fields'	=> array( 'connector_border_width', 'connector_border_color' )
								),
								'dashed'	=> array(
									'fields'	=> array( 'connector_border_width', 'connector_border_color' )
								),
								'dotted'	=> array(
									'fields'	=> array( 'connector_border_width', 'connector_border_color' )
								),
								'double'	=> array(
									'fields'	=> array( 'connector_border_width', 'connector_border_color' )
								)
							),
					),
					'connector_border_width' 	=> array(
						'type'			=> 'text',
						'label'			=> __( 'Line Thickness', 'uabb' ),
						'placeholder'	=> '1',
						'size'			=> '5',
						'description'	=> 'px',
					),
					'connector_border_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Line Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
					),
				)
			),
			'outer_background'	=> array(
				'title'         => __( 'Info Circle Background', 'uabb' ),
				'fields'        => array(
					'outer_bg_type' => array(
							'type'          => 'select',
							'label'         => __( 'Background Type', 'uabb' ),
							'default'       => 'none',
							'options'       => array(
								'none'			=> __( 'None', 'uabb' ),
								'color'			=> __( 'Color', 'uabb' ),
								'image'			=> __( 'Image', 'uabb' ),
							),
							'toggle'	=> array(
								'color'		=> array(
									'fields'	=> array( 'outer_bg_color', 'outer_bg_color_opc' )
								),
								'image'	=> array(
									'fields'	=> array( 'outer_bg_img', 'outer_bg_img_pos', 'outer_bg_img_size', 'outer_bg_img_repeat' )
								),
							),
							'help' => __( 'Use this color only when you want same color or image to Info Circle Background', 'uabb' ),
					),
					'outer_bg_img'         => array(
						'type'          => 'photo',
						'label'         => __( 'Photo', 'uabb' ),
						'show_remove'	=> true,
						'connections' => array( 'photo' )
					),
					'outer_bg_img_pos' => array(
							'type'          => 'select',
							'label'         => __( 'Background Position', 'uabb' ),
							'default'       => 'center center',
							'options'       => array(
								'left top'			=> __( 'Left Top', 'uabb' ),
								'left center'		=> __( 'Left Center', 'uabb' ),
								'left bottom'		=> __( 'Left Bottom', 'uabb' ),
								'center top'		=> __( 'Center Top', 'uabb' ),
								'center center'		=> __( 'Center Center', 'uabb' ),
								'center bottom'		=> __( 'Center Bottom', 'uabb' ),
								'right top'			=> __( 'Right Top', 'uabb' ),
								'right center'		=> __( 'Right Center', 'uabb' ),
								'right bottom'		=> __( 'Right Bottom', 'uabb' ),
							),
					),
					'outer_bg_img_repeat' => array(
							'type'          => 'select',
							'label'         => __( 'Background Repeat', 'uabb' ),
							'default'       => 'repeat',
							'options'       => array(
								'no-repeat'		=> __( 'No Repeat', 'uabb' ),
								'repeat'		=> __( 'Repeat All', 'uabb' ),
								'repeat-x'		=> __( 'Repeat Horizontally', 'uabb' ),
								'repeat-y'		=> __( 'Repeat Vertically', 'uabb' ),
							),
					),
					'outer_bg_img_size' => array(
							'type'          => 'select',
							'label'         => __( 'Background Size', 'uabb' ),
							'default'       => 'cover',
							'options'       => array(
								'contain'	=> __( 'Contain', 'uabb' ),
								'cover'		=> __( 'Cover', 'uabb' ),
								'initial'	=> __( 'Initial', 'uabb' ),
								'inherit'	=> __( 'Inherit', 'uabb' ),
							),
					),
					'outer_bg_color' => array( 
						'type'       => 'color',
						'label'		 => __( 'Background Color', 'uabb' ),
						'default'    => '',
						'show_reset' => true,
					),
					'outer_bg_color_opc' => array( 
						'type'        => 'text',
						'label'		  => __( 'Background Color Opacity', 'uabb' ),
						'default'     => '',
						'description' => '%',
						'maxlength'   => '3',
						'size'        => '5',
					),
				)
			),
		)
	),
	'typography'         => array(
		'title'         => __( 'Typography', 'uabb' ),
		'sections'      => array(
			'title_typography'    =>  array(
				'title' => __( 'Title', 'uabb' ),
                'fields'    => array(
                    'tag_selection'   => array(
                        'type'          => 'select',
                        'label'         => __('Tag', 'uabb'),
                        'default'       => 'h3',
                        'options'       => array(
                            'h1'      => __('H1', 'uabb'),
                            'h2'      => __('H2', 'uabb'),
                            'h3'      => __('H3', 'uabb'),
                            'h4'      => __('H4', 'uabb'),
                            'h5'      => __('H5', 'uabb'),
                            'h6'      => __('H6', 'uabb'),
                            'div'     => __('Div', 'uabb'),
                            'p'       => __('p', 'uabb'),
                            'span'    => __('span', 'uabb'),
                        )
                    ),
                    'font_family'       => array(
                        'type'          => 'font',
                        'label'         => __('Font Family', 'uabb'),
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 'Default'
                        ),
                        'preview'	=> array(
                            'type'		=> 'font',
                            'selector'	=> '.uabb-info-circle-title'
                    	),
                    ),
                    'font_size'     => array(
                        'type'          => 'uabb-simplify',
                        'label'         => __( 'Font Size', 'uabb' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'line_height'    => array(
                        'type'          => 'uabb-simplify',
                        'label'         => __( 'Line Height', 'uabb' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'color'        => array( 
                        'type'       => 'color',
                        'label'      => __('Color', 'uabb'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'title_margin_top' => array(
						'type'              => 'text',
						'label'             => __( 'Margin Top', 'uabb' ),
						'placeholder'		=> '0',
						'maxlength'         => '3',
						'size'              => '4',
						'description'       => 'px',
					),
					'title_margin_bottom' => array(
						'type'              => 'text',
						'label'             => __( 'Margin Bottom', 'uabb' ),
						'placeholder'		=> '20',
						'maxlength'         => '3',
						'size'              => '4',
						'description'       => 'px',
					),
                )
            ),
			'desc_typography'    =>  array(
				'title' => __( 'Description', 'uabb' ),
                'fields'    => array(
                    'desc_font_family'       => array(
                        'type'          => 'font',
                        'label'         => __('Font Family', 'uabb'),
                        'default'       => array(
                            'family'        => 'Default',
                            'weight'        => 'Default'
                        ),
                        'preview'	=> array(
                            'type'		=> 'font',
                            'selector'	=> '.uabb-info-circle-desc'
                    	),
                    ),
                    'desc_font_size'     => array(
                        'type'          => 'uabb-simplify',
                        'label'         => __( 'Font Size', 'uabb' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'desc_line_height'    => array(
                        'type'          => 'uabb-simplify',
                        'label'         => __( 'Line Height', 'uabb' ),
                        'default'       => array(
                            'desktop'       => '',
                            'medium'        => '',
                            'small'         => '',
                        ),
                    ),
                    'desc_color'        => array( 
                        'type'       => 'color',
                        'label'      => __('Color', 'uabb'),
                        'default'    => '',
                        'show_reset' => true,
                    ),
                    'desc_margin_top' => array(
						'type'              => 'text',
						'label'             => __( 'Margin Top', 'uabb' ),
						'placeholder'		=> '20',
						'maxlength'         => '3',
						'size'              => '4',
						'description'       => 'px',
					),
					'desc_margin_bottom' => array(
						'type'              => 'text',
						'label'             => __( 'Margin Bottom', 'uabb' ),
						'placeholder'		=> '0',
						'maxlength'         => '3',
						'size'              => '4',
						'description'       => 'px',
					),
                )
            ),
		)
	)
));

//Add Circle Items
FLBuilder::register_settings_form('info_circle_items_form', array(
	'title' => __( 'Add Circle Item', 'uabb' ),
	'tabs'  => array(
		'circle_item_general'      => array(
			'title'         => __( 'General', 'uabb' ),
			'sections'      => array(
				'title'       => array(
					'title'         => '',
					'fields'        => array(
						'circle_item_title'	=> array(
							'type'		  => 'text',
							'label'		  => __( 'Title', 'uabb' ),
							'description' => '',
							'default'	  => __( 'Info Circle', 'uabb' ),
							'placeholder' => __( 'Title', 'uabb' ),
							'class'		  => 'uabb-circle-item-title',
							'connections' => array( 'string', 'html' )
						),
					)
				),
				'description'	=> array( 
					'title'  		=> __( 'Description - This is the content which will be displayed inside the circle', 'uabb' ),
					'fields' 		=> array(
						'circle_item_description'	=> array(
							'type'   	=> 'editor',
							'default'	=> __( 'Nuper turba hunc viseret foret vultus. Conversa turba orbem coeptis fossae liquidas. Innabilis membra est quisque evolvit praebebat vos his adsiduis. Matutinis caelo speciem capacius tempora posset: sic. Instabilis magni alta erat: unus divino obliquis igni turba.', 'uabb' ),
							'label'  	=> '',
							'rows'   	=> 13,
							'connections'	=> array( 'string', 'html' )
						)
					),
				),
				'cta'	=> array(
					'title'         => __( 'Call To Action - CTA', 'uabb' ),
					'fields'        => array(
						'cta' => array(
							'type'          => 'select',
							'label'         => __( 'CTA Link', 'uabb' ),
							'default'       => 'none',
							'options'       => array(
								'none'			=> __( 'None', 'uabb' ),
								'icon'			=> __( 'To Icon', 'uabb' ),
								'desc'			=> __( 'In Description', 'uabb' ),
								'both'			=> __( 'Both', 'uabb' ),
							),
							'help'			=> __('Select the area where you wish to apply call to action link.', 'uabb'),
							'toggle'	=> array(
								'icon'		=> array(
									'fields'	=> array( 'cta_link', 'cta_link_target' )
								),
								'desc'	=> array(
									'fields'	=> array( 'desc_cta_type', 'cta_link', 'cta_link_target', 'cta_text' ),
									'tabs'	=> array( 'cta_typography' )
								),
								'both'	=> array(
									'fields'	=> array( 'desc_cta_type', 'cta_link', 'cta_link_target', 'cta_text' ),
									'tabs'	=> array( 'cta_typography' )
								),
							),
						),
						'desc_cta_type' => array(
							'type'          => 'select',
							'label'         => __( 'Description CTA', 'uabb' ),
							'default'       => 'none',
							'help'			=> __('Select the type of call to action link which appears inside description area.', 'uabb'),
							'options'       => array(
								'text'			=> __( 'Text', 'uabb' ),
								'button'		=> __( 'Button', 'uabb' ),
							),
							'toggle'	=> array(
								'button'	=> array(
									'tabs'	=> array( 'cta_button' )
								),
								'text'	=> array(
									'fields'	=> array( 'btn_color' )
								),
							),
						),
						'cta_text'      => array(
							'type'          => 'text',
							'label'         => __('Text', 'uabb'),
							'default'       => __('Read More', 'uabb'),
							'connections'	=> array( 'string', 'html' )
						),
						'cta_link'          => array(
							'type'          => 'link',
							'label'         => __('Link', 'uabb'),
							'help'          => __('The link applies to the entire module. If choosing a call to action type below, this link will also be used for the text or button.', 'uabb'),
							'preview'       => array(
								'type'          => 'none'
							),
							'connections'	=> array( 'url' )
						),
						'cta_link_target'   => array(
							'type'          => 'select',
							'label'         => __('Link Target', 'uabb'),
							'default'       => '_self',
							'options'       => array(
								'_self'         => __('Same Window', 'uabb'),
								'_blank'        => __('New Window', 'uabb')
							),
							'preview'       => array(
							    'type'          => 'none'
							)
						),
					)
				),
				'inner_circle_background'	=> array(
					'title'         => __( 'Information Circle Style', 'uabb' ),
					'fields'        => array(
						'inner_circle_bg_type' => array(
								'type'          => 'select',
								'label'         => __( 'Background Type', 'uabb' ),
								'default'       => 'none',
								'options'       => array(
									'none'			=> __( 'Default', 'uabb' ),
									'color'			=> __( 'Color', 'uabb' ),
									'image'			=> __( 'Image', 'uabb' ),
								),
								'toggle'	=> array(
									'color'		=> array(
										'fields'	=> array( 'inner_circle_bg_color', 'inner_circle_bg_color_opc' )
									),
									'image'	=> array(
										'fields'	=> array( 'inner_circle_bg_img', 'inner_circle_bg_img_pos', 'inner_circle_bg_img_size', 'inner_circle_bg_img_repeat' )
									),
								),
								'help'          => __( 'Select the background for content area. Keep default for global background color.', 'uabb' ),
						),
						'inner_circle_bg_img'         => array(
							'type'          => 'photo',
							'label'         => __( 'Photo', 'uabb' ),
							'show_remove'	=> true,
							'connections'	=> array( 'photo' )
						),
						'inner_circle_bg_img_pos' => array(
								'type'          => 'select',
								'label'         => __( 'Background Position', 'uabb' ),
								'default'       => 'center center',
								'options'       => array(
									'left top'			=> __( 'Left Top', 'uabb' ),
									'left center'		=> __( 'Left Center', 'uabb' ),
									'left bottom'		=> __( 'Left Bottom', 'uabb' ),
									'center top'		=> __( 'Center Top', 'uabb' ),
									'center center'		=> __( 'Center Center', 'uabb' ),
									'center bottom'		=> __( 'Center Bottom', 'uabb' ),
									'right top'			=> __( 'Right Top', 'uabb' ),
									'right center'		=> __( 'Right Center', 'uabb' ),
									'right bottom'		=> __( 'Right Bottom', 'uabb' ),
								),
						),
						'inner_circle_bg_img_repeat' => array(
								'type'          => 'select',
								'label'         => __( 'Background Repeat', 'uabb' ),
								'default'       => 'repeat',
								'options'       => array(
									'no-repeat'		=> __( 'No Repeat', 'uabb' ),
									'repeat'		=> __( 'Repeat All', 'uabb' ),
									'repeat-x'		=> __( 'Repeat Horizontally', 'uabb' ),
									'repeat-y'		=> __( 'Repeat Vertically', 'uabb' ),
								),
						),
						'inner_circle_bg_img_size' => array(
								'type'          => 'select',
								'label'         => __( 'Background Size', 'uabb' ),
								'default'       => 'cover',
								'options'       => array(
									'contain'	=> __( 'Contain', 'uabb' ),
									'cover'		=> __( 'Cover', 'uabb' ),
									'initial'	=> __( 'Initial', 'uabb' ),
									'inherit'	=> __( 'Inherit', 'uabb' ),
								),
						),
						'inner_circle_bg_color' => array( 
							'type'       => 'color',
							'label'		 => __( 'Background Color', 'uabb' ),
							'default'    => '',
							'show_reset' => true,
						),
						'inner_circle_bg_color_opc' => array( 
							'type'        => 'text',
							'label'		=> __( 'Background Color Opacity', 'uabb' ),
							'default'     => '',
							'description' => '%',
							'maxlength'   => '3',
							'size'        => '5',
						),
						'separator_color' => array( 
							'type'       => 'color',
							'label'		 => __( 'Separator Color', 'uabb' ),
							'default'    => '',
							'show_reset' => true,
							'help'		 => __( 'Use this for unique separator colors', 'uabb' ),
						),
					)
				),
			)
		),
		'circle_item_image' => array(
			'title'         => __( 'Icon / Image', 'uabb' ),
			'sections'      => array(
				'title'       => array(
					'title'         => '',
					'fields'        => array(
						'image_type'    => array(
							'type'          => 'select',
							'label'         => __( 'Image Type', 'uabb' ),
							'default'       => 'icon',
							'options'       => array(
								'icon'          => __( 'Icon', 'uabb' ),
								'photo'         => __( 'Photo', 'uabb' ),
							),
							'toggle'        => array(
								'icon'          => array(
									'fields'   => array( 'icon_gradient' ),
									'sections'   => array( 'icon_basic', 'icon_colors', 'icon_active_colors' ),
								),
								'photo'         => array(
									'sections'   => array( 'img_basic', 'img_active_effects' ),
								)
							),
						),
					),
				),
				/* Icon Basic Setting */
				'icon_basic' => array( // Section
					'title'		=> __( 'Icon', 'uabb' ), // Section Title
					'fields'	=> array( // Section Fields
						'icon'		=> array(
							'type'			=> 'icon',
							'label'			=> __( 'Icon', 'uabb' ),
							'default'		=> 'ua-icon ua-icon-pencil',
							'show_remove'	=> true,
						),
					)
				),
				'icon_colors' => array( // Section
					'title'		=> __( 'Icon Colors', 'uabb' ), // Section Title
					'fields'	=> array( // Section Fields
						'icon_color' => array( 
							'type'       => 'color',
							'label'	=> __( 'Icon Color', 'uabb' ),
							'default'    => '',
							'show_reset' => true,
						),
						'icon_bg_color' => array( 
							'type'       => 'color',
							'label'		 => __( 'Icon Background Color', 'uabb' ),
							'default'    => '',
							'show_reset' => true,
						),
						'icon_gradient'     => array(
							'type'          => 'uabb-toggle-switch',
							'label'         => __( 'Gradient', 'uabb' ),
							'default'       => '0',
							'options'       => array(
								'1'		=> __('Yes','uabb'),
								'0'		=> __('No','uabb'),
							),
						),
					)
				),
				'icon_active_colors' => array( // Section
					'title'		=> __( 'Icon Active Colors', 'uabb' ), // Section Title
					'fields'	=> array( // Section Fields
						'icon_hover_color' => array( 
							'type'       => 'color',
							'label'		 => __( 'Icon Hover/Active Color', 'uabb' ),
							'default'    => '',
							'show_reset' => true,
						),
						'icon_bg_hover_color' => array( 
							'type'       => 'color',
							'label'		 => __( 'Icon Hover/Active Background Color', 'uabb' ),
							'default'    => '',
							'show_reset' => true,
						),
					)
				),
				/* Image Basic Setting */
				'img_basic'     => array( // Section
					'title'         => __( 'Image', 'uabb'), // Section Title
					'fields'        => array( // Section Fields
						'photo_source'  => array(
							'type'          => 'select',
							'label'         => __( 'Photo Source', 'uabb' ),
							'default'       => 'library',
							'options'       => array(
								'library'       => __( 'Media Library', 'uabb' ),
								'url'           => __( 'URL', 'uabb' )
							),
							'toggle'        => array(
								'library'       => array(
									'fields'        => array('photo')
								),
								'url'           => array(
									'fields'        => array('photo_url' )
								)
							)
						),
						'photo'         => array(
							'type'          => 'photo',
							'label'         => __( 'Photo', 'uabb' ),
							'show_remove'	=> true,
							'connections'	=> array( 'photo' )
						),
						'photo_url'     => array(
							'type'          => 'text',
							'label'         => __( 'Photo URL', 'uabb' ),
							'placeholder'   => 'http://www.example.com/my-photo.jpg',
							'connections'	=> array( 'url' )
						),
				    )
				),
				'img_active_effects'     => array( // Section
					'title'         => __( 'Image Active Effects', 'uabb'), // Section Title
					'fields'        => array( // Section Fields
						'photo_active_type'  => array(
							'type'          => 'select',
							'label'         => __( 'Photo Active Effect', 'uabb' ),
							'default'       => 'none',
							'options'       => array(
								'none'       	=> __( 'No Effect', 'uabb' ),
								'grayscale'		=> __( 'Grayscale', 'uabb' ),
								'change-img'	=> __( 'Change Image', 'uabb' )
							),
							'toggle'        => array(
								'change-img'       => array(
									'fields'        => array( 'active_photo_source' )
								),
							)
						),
						'active_photo_source'  => array(
							'type'          => 'select',
							'label'         => __( 'Photo Source', 'uabb' ),
							'default'       => 'library',
							'options'       => array(
								'library'       => __( 'Media Library', 'uabb' ),
								'url'           => __( 'URL', 'uabb' )
							),
							'toggle'        => array(
								'library'       => array(
									'fields'        => array( 'active_photo' )
								),
								'url'           => array(
									'fields'        => array( 'active_photo_url' )
								)
							)
						),
						'active_photo'         => array(
							'type'          => 'photo',
							'label'         => __( 'Photo', 'uabb' ),
							'show_remove'	=> true,
							'connections'	=> array( 'photo' )
						),
						'active_photo_url'     => array(
							'type'          => 'text',
							'label'         => __( 'Photo URL', 'uabb' ),
							'placeholder'   => 'http://www.example.com/my-photo.jpg',
							'connections'	=> array( 'string', 'html' )
						),
				    )
				),
			),
		),
		'cta_button' => array(
			'title'         => __( 'CTA Button', 'uabb' ),
			'sections'      => array(
				'btn-style'      => array(
	                'title'         => __('Style', 'uabb'),
	                'fields'        => array(
	                    'btn_style'         => array(
	                        'type'          => 'select',
	                        'label'         => __('Style', 'uabb'),
	                        'default'       => 'flat',
	                        'class'         => 'creative_button_styles',
	                        'options'       => array(
	                            'flat'          => __('Flat', 'uabb'),
	                            'gradient'      => __('Gradient', 'uabb'),
	                            'transparent'   => __('Transparent', 'uabb'),
	                            'threed'          => __('3D', 'uabb'),
	                        ),
	                    ),
	                    'btn_border_size'   => array(
	                        'type'          => 'text',
	                        'label'         => __('Border Size', 'uabb'),
	                        'description'   => 'px',
	                        'maxlength'     => '3',
	                        'size'          => '5',
	                        'placeholder'   => '2'
	                    ),
	                    'btn_transparent_button_options'         => array(
	                        'type'          => 'select',
	                        'label'         => __('Hover Styles', 'uabb'),
	                        'default'       => 'transparent-fade',
	                        'options'       => array(
	                            'none'          => __('None', 'uabb'),
	                            'transparent-fade'          => __('Fade Background', 'uabb'),
	                            'transparent-fill-top'      => __('Fill Background From Top', 'uabb'),
	                            'transparent-fill-bottom'      => __('Fill Background From Bottom', 'uabb'),
	                            'transparent-fill-left'     => __('Fill Background From Left', 'uabb'),
	                            'transparent-fill-right'     => __('Fill Background From Right', 'uabb'),
	                            'transparent-fill-center'       => __('Fill Background Vertical', 'uabb'),
	                            'transparent-fill-diagonal'     => __('Fill Background Diagonal', 'uabb'),
	                            'transparent-fill-horizontal'  => __('Fill Background Horizontal', 'uabb'),
	                        ),
	                    ),
	                    'btn_threed_button_options'         => array(
	                        'type'          => 'select',
	                        'label'         => __('Hover Styles', 'uabb'),
	                        'default'       => 'threed_down',
	                        'options'       => array(
	                            'threed_down'          => __('Move Down', 'uabb'),
	                            'threed_up'      => __('Move Up', 'uabb'),
	                            'threed_left'      => __('Move Left', 'uabb'),
	                            'threed_right'     => __('Move Right', 'uabb'),
	                            'animate_top'     => __('Animate Top', 'uabb'),
	                            'animate_bottom'     => __('Animate Bottom', 'uabb'),
	                            /*'animate_left'     => __('Animate Left', 'uabb'),
	                            'animate_right'     => __('Animate Right', 'uabb'),*/
	                        ),
	                    ),
	                    'btn_flat_button_options'         => array(
	                        'type'          => 'select',
	                        'label'         => __('Hover Styles', 'uabb'),
	                        'default'       => 'none',
	                        'options'       => array(
	                            'none'          => __('None', 'uabb'),
	                            'animate_to_left'      => __('Appear Icon From Right', 'uabb'),
	                            'animate_to_right'          => __('Appear Icon From Left', 'uabb'),
	                            'animate_from_top'      => __('Appear Icon From Top', 'uabb'),
	                            'animate_from_bottom'     => __('Appear Icon From Bottom', 'uabb'),
	                        ),
	                    ),
	                )
	            ),
				'btn-icon'       => array( // Section
	                'title'         => __('Icons', 'uabb'),
	                'fields'        => array(
	                    'btn_icon'          => array(
	                        'type'          => 'icon',
	                        'label'         => __('Icon', 'uabb'),
	                        'show_remove'   => true
	                    ),
	                    'btn_icon_position' => array(
	                        'type'          => 'select',
	                        'label'         => __('Icon Position', 'uabb'),
	                        'default'       => 'before',
	                        'options'       => array(
	                            'before'        => __('Before Text', 'uabb'),
	                            'after'         => __('After Text', 'uabb')
	                        )
	                    )
	                )
	            ),
				'btn-colors'     => array( // Section
	                'title'         => __('Colors', 'uabb'),
	                'fields'        => array(
	                    'btn_text_color'        => array( 
	                        'type'       => 'color',
	                        'label'      => __('Text Color', 'uabb'),
	                        'default'    => '',
	                        'show_reset' => true,
	                    ),
	                    'btn_text_hover_color'        => array( 
	                        'type'       => 'color',
	                        'label'      => __('Text Hover Color', 'uabb'),
	                        'default'    => '',
	                        'show_reset' => true,
	                        'preview'       => array(
	                            'type'          => 'none'
	                        )
	                    ),
	                    'btn_bg_color'        => array( 
	                        'type'       => 'color',
	                        'label'      => __('Background Color', 'uabb'),
	                        'default'    => '',
	                        'show_reset' => true,
	                    ),
	                    'btn_bg_color_opc'    => array( 
	                        'type'        => 'text',
	                        'label'       => __('Opacity', 'uabb'),
	                        'default'     => '',
	                        'description' => '%',
	                        'maxlength'   => '3',
	                        'size'        => '5',
	                    ),

	                    'btn_bg_hover_color'        => array( 
	                        'type'       => 'color',
	                        'label'         => __('Background Hover Color', 'uabb'),
	                        'default'    => '',
	                        'show_reset' => true,
	                        'preview'       => array(
	                            'type'          => 'none'
	                        )
	                    ),
	                    'btn_bg_hover_color_opc'    => array( 
	                        'type'        => 'text',
	                        'label'       => __('Opacity', 'uabb'),
	                        'default'     => '',
	                        'description' => '%',
	                        'maxlength'   => '3',
	                        'size'        => '5',
	                    ),
	                    'hover_attribute' => array(
	                        'type'          => 'uabb-toggle-switch',
	                        'label'         => __( 'Apply Hover Color To', 'uabb' ),
	                        'default'       => 'bg',
	                        'options'       => array(
	                            'border'    => __( 'Border', 'uabb' ),
	                            'bg'        => __( 'Background', 'uabb' ),
	                        ),
	                        'width' => '75px'
	                    ),
	                )
	            ),
				'btn-structure'  => array(
	                'title'         => __('Structure', 'uabb'),
	                'fields'        => array(
	                    'btn_width'         => array(
	                        'type'          => 'select',
	                        'label'         => __('Width', 'uabb'),
	                        'default'       => 'auto',
	                        'options'       => array(
	                            'auto'          => _x( 'Auto', 'Width.', 'uabb' ),
	                            'full'          => __('Full Width', 'uabb'),
	                            'custom'        => __('Custom', 'uabb')
	                        ),
	                        'toggle'        => array(
	                            'auto'          => array(
	                                'fields'        => array('btn_align', 'btn_mob_align')
	                            ),
	                            'full'          => array(
	                                'fields'        => array( )
	                            ),
	                            'custom'        => array(
	                                'fields'        => array('btn_align', 'btn_mob_align', 'btn_custom_width', 'btn_custom_height', 'btn_padding_top_bottom', 'btn_padding_left_right' )
	                            )
	                        )
	                    ),
	                    'btn_custom_width'  => array(
	                        'type'          => 'text',
	                        'label'         => __('Custom Width', 'uabb'),
	                        'default'       => '200',
	                        'maxlength'     => '3',
	                        'size'          => '4',
	                        'description'   => 'px'
	                    ),
	                    'btn_custom_height'  => array(
	                        'type'          => 'text',
	                        'label'         => __('Custom Height', 'uabb'),
	                        'default'       => '45',
	                        'maxlength'     => '3',
	                        'size'          => '4',
	                        'description'   => 'px'
	                    ),
	                    'btn_padding_top_bottom'       => array(
	                        'type'          => 'text',
	                        'label'         => __('Padding Top/Bottom', 'uabb'),
	                        'placeholder'   => '0',
	                        'maxlength'     => '3',
	                        'size'          => '4',
	                        'description'   => 'px'
	                    ),
	                    'btn_padding_left_right'       => array(
	                        'type'          => 'text',
	                        'label'         => __('Padding Left/Right', 'uabb'),
	                        'placeholder'   => '0',
	                        'maxlength'     => '3',
	                        'size'          => '4',
	                        'description'   => 'px'
	                    ),
	                    'btn_border_radius' => array(
	                        'type'          => 'text',
	                        'label'         => __('Round Corners', 'uabb'),
	                        'maxlength'     => '3',
	                        'size'          => '4',
	                        'description'   => 'px'
	                    ),
	                )
	            ),
			),
		),
		'cta_typography' => array(
			'title'         => __( 'CTA Typography', 'uabb' ),
			'sections'      => array(
				'typography'    =>  array(
					'title' 	=> __( 'CTA Typography', 'uabb' ),
	                'fields'    => array(
	                    'btn_font_family'       => array(
	                        'type'          => 'font',
	                        'label'         => __('Font Family', 'uabb'),
	                        'default'       => array(
	                            'family'        => 'Default',
	                            'weight'        => 'Default'
	                        ),
	                    ),
	                    'btn_font_size'     => array(
	                        'type'          => 'uabb-simplify',
	                        'label'         => __( 'Font Size', 'uabb' ),
	                        'default'       => array(
	                            'desktop'       => '',
	                            'medium'        => '',
	                            'small'         => '',
	                        ),
	                    ),
	                    'btn_line_height'    => array(
	                        'type'          => 'uabb-simplify',
	                        'label'         => __( 'Line Height', 'uabb' ),
	                        'default'       => array(
	                            'desktop'       => '',
	                            'medium'        => '',
	                            'small'         => '',
	                        ),
	                    ),
	                    'btn_color'        => array( 
	                        'type'       => 'color',
	                        'label'      => __('Color', 'uabb'),
	                        'default'    => '',
	                        'show_reset' => true,
	                    ),
	                )
	            ),
			),
		)
	)
));