<?php

class StaffBBModule extends \FLBuilderModule
{

	public function __construct()
	{
		global $hipStaff;

		parent::__construct(array(
			'name' => __('Staff Module', 'fl-builder'),
			'description' => __('Our Staffs', 'fl-builder'),
			'category'    => 'Hip Modules',
			'dir'             => $hipStaff['dir'] . '/staff-bb-module/',
			'url'             => $hipStaff['url'] . '/staff-bb-module/',
			'partial_refresh' => true
		));
		$this->add_css('jquery-bxslider');
		$this->add_js('jquery-bxslider');
		$this->icon = $this->moduleIcon();
	}

	public function moduleIcon($icon = '')
	{
		return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M8.03 4.46c-.29 1.28.55 3.46 1.97 3.46 1.41 0 2.25-2.18 1.96-3.46-.22-.98-1.08-1.63-1.96-1.63-.89 0-1.74.65-1.97 1.63zm-4.13.9c-.25 1.08.47 2.93 1.67 2.93s1.92-1.85 1.67-2.93c-.19-.83-.92-1.39-1.67-1.39s-1.48.56-1.67 1.39zm8.86 0c-.25 1.08.47 2.93 1.66 2.93 1.2 0 1.92-1.85 1.67-2.93-.19-.83-.92-1.39-1.67-1.39-.74 0-1.47.56-1.66 1.39zm-.59 11.43l1.25-4.3C14.2 10 12.71 8.47 10 8.47c-2.72 0-4.21 1.53-3.44 4.02l1.26 4.3C8.05 17.51 9 18 10 18c.98 0 1.94-.49 2.17-1.21zm-6.1-7.63c-.49.67-.96 1.83-.42 3.59l1.12 3.79c-.34.2-.77.31-1.2.31-.85 0-1.65-.41-1.85-1.03l-1.07-3.65c-.65-2.11.61-3.4 2.92-3.4.27 0 .54.02.79.06-.1.1-.2.22-.29.33zm8.35-.39c2.31 0 3.58 1.29 2.92 3.4l-1.07 3.65c-.2.62-1 1.03-1.85 1.03-.43 0-.86-.11-1.2-.31l1.11-3.77c.55-1.78.08-2.94-.42-3.61-.08-.11-.18-.23-.28-.33.25-.04.51-.06.79-.06z"/></g></svg>';
	}
}
if(class_exists('\Hip\Theme\Settings\General\Settings')){
	$general_settings = \Hip\Theme\Settings\General\Settings::getSettings();
}

\FLBuilder::register_module( 'StaffBBModule', array(
	'tab-1'      => array(
		'title'         => __( 'General', 'fl-builder' ),
		'sections'      => array(
			'general'  => array(
				'title'         => __( 'General Settings', 'fl-builder' ),
				'fields'        => array( // Section Fields
					'headline' => array(
						'type'          => 'text',
						'label'         => __( 'Headline', 'fl-builder' )
					),
					'match_staff_categories' => array(
						'type'         => 'select',
						'label'        => __('Staff Categories', 'fl-builder'),
						'default'      => 'match',
						'size' => 100,
						'options'      => array(
							'match' => 'Match these staff categories',
							'exclude' => 'Exclude these staff categories'
						)
					),
					'staff_categories' => array(
						'type'          => 'suggest',
						'label'         => __(' ', 'fl-builder'),
						'action'        => 'fl_as_terms',
						'data'          => 'staff_category',
					),
					'desc_length' => array(
						'type'          => 'text',
						'label'         => __( 'Description', 'fl-builder' ),
						'default'       => '30',
						'description'   => 'words',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0',
						'sanitize'		=> 'absint',
					),
					'button_text' => array(
						'type'          => 'text',
						'label'         => __( 'Read more button text', 'fl-builder' )
					)
				)
			),
			'slider'  => array(
				'title'         => __( 'Slider Settings', 'fl-builder' ),
				'fields'        => array( // Section Fields
					'slider_min_height' => array(
						'type'          => 'text',
						'label'         => __( 'Slider min height', 'fl-builder' ),
						'default'       => '450',
						'description'   => 'px',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0',
						'sanitize'		=> 'absint',
					),
					'pagination'     => array(
						'type'          => 'select',
						'label'         => __('Show Dots', 'fl-builder'),
						'default'       => 'no',
						'options'       => array(
							'no'			=> __('No', 'fl-builder'),
							'yes'       	=> __('Yes', 'fl-builder'),
						)
					),
					'navigation'     => array(
						'type'          => 'select',
						'label'         => __('Show Arrows', 'fl-builder'),
						'default'       => 'yes',
						'options'       => array(
							'no'            => __('No', 'fl-builder'),
							'yes'        	=> __('Yes', 'fl-builder'),
						)
					)
				)
			)
		)
	),
	'tab-2'      => array(
		'title'         => __( 'Style', 'fl-builder' ),
		'sections'      => array(
			'general' => array(
				'title' => __('General','fl-builder'),
				'fields'        => array(
					'headline_color' => array(
						'type'          => 'color',
						'label'         => __( 'Headline Color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_color']) ? str_replace('#', '', $general_settings['primary_color']) : '965f48',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'name_color' => array(
						'type'          => 'color',
						'label'         => __( 'Staff Name Color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_color']) ? str_replace('#', '', $general_settings['primary_color']) : '965f48',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'desc_color' => array(
						'type'          => 'color',
						'label'         => __( 'Staff description Color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_color']) ? str_replace('#', '', $general_settings['primary_color']) : '965f48',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'content_bg' => array(
						'type'          => 'color',
						'label'         => __( 'Content Background', 'fl-builder' ),
						'default'       => 'f7f7f7',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'content_bg_image' => array(
						'type'          => 'photo',
						'label'         => __('Content Background Image', 'fl-builder'),
						'show_remove'   => true,
					),
					'content_bg_image_opacity' => array(
						'type'          => 'text',
						'label'         => __( 'Background Image Opacity', 'fl-builder' ),
						'default'       => '30',
						'description'   => '%',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0',
						'sanitize'		=> 'absint',
					),
				)
			),
			'button' => array(
				'title' => __('Read more button','fl-builder'),
				'fields'        => array(
					'button_bg' => array(
						'type'          => 'color',
						'label'         => __( 'Background color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_color']) ? str_replace('#', '', $general_settings['primary_color']) : '965f48',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'button_hover_bg' => array(
						'type'          => 'color',
						'label'         => __( 'Background color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_highlight_color']) ? str_replace('#', '', $general_settings['primary_highlight_color']) : 'eb9e24',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'button_border_color' => array(
						'type'          => 'color',
						'label'         => __( 'Border color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_highlight_color']) ? str_replace('#', '', $general_settings['primary_highlight_color']) : 'eb9e24',
						'show_reset'    => true,
						'show_alpha'    => false
					),
				)
			),
			'arrow' => array(
				'title' => __('Slider arrow','fl-builder'),
				'fields'        => array(
					'arrow_bg' => array(
						'type'          => 'color',
						'label'         => __( 'Background color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_color']) ? str_replace('#', '', $general_settings['primary_color']) : '965f48',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'arrow_icon_color' => array(
						'type'          => 'color',
						'label'         => __( 'Icon color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_highlight_color']) ? str_replace('#', '', $general_settings['primary_highlight_color']) : 'eb9e24',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'arrow_border_color' => array(
						'type'          => 'color',
						'label'         => __( 'Border color', 'fl-builder' ),
						'default'       => !empty($general_settings['primary_highlight_color']) ? str_replace('#', '', $general_settings['primary_highlight_color']) : 'eb9e24',
						'show_reset'    => true,
						'show_alpha'    => false
					)
				)
			),
		)
	)
) );

?>