<?php


class FLFeaturedServiceModule extends FLBuilderModule
{
	public function __construct()
	{
		global $hipServices;
		parent::__construct(array(
			'name' => __('Featured Service Module', 'fl-builder'),
			'description' => __('Featured Service!', 'fl-builder'),
			'category' => __('Hip Modules', 'fl-builder'),
			'dir'             => $hipServices['dir'] . 'featured-service-module/',
			'url'             => $hipServices['url'] . 'featured-service-module/',
			'partial_refresh' => true // Defaults to false and can be omitted.
		));
	}
}
//var_dump($_GLOBALS['cpt_init_data']);

FLBuilder::register_module('FLFeaturedServiceModule', array(
	'tab-1'      => array(
		'title'         => __('General', 'fl-builder'),
		'sections'      => array(
			'general-section'  => array(
				'fields'        => array(

					'headline' => array(
						'type'          => 'text',
						'label'         => __('Headline', 'fl-builder'),
						'default'       => __('Services', 'fl-builder')
					),
					'featured_content' => array(
						'type'      => 'text',
						'label'     => __('Featured Post Content Words', 'fl-builder'),
						'default'   => '20',
						'size'      => '3'
					),
				)
			),
		)
	),

	'tab-2' => array(
		'title'       => __('Styles', 'fl-builder'),
		'sections'    => array(
			'general_featured' => array(
				'fields'         => array(
					'featured_post_l_padding' => array(
						'type'          => 'text',
						'label'         => __('Featured Post Left Padding', 'fl-builder'),
						'default'   => '0',
						'size'      => '3',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '',
							'property' => 'font-size',
							'unit'     => 'px'
						)
					),
					'featured_post_tb_padding' => array(
						'type'          => 'text',
						'label'         => __('Featured Post Top Bottom Padding', 'fl-builder'),
						'default'   => '60',
						'size'      => '3',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '',
							'property' => 'font-size',
							'unit'     => 'px'
						)

					),
					'featured_post_overlay_color' => array(
						'type'          => 'color',
						'label'         => __('Featured Image Overlay', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'featured_post_overlay_opacity' => array(
						'type'      => 'text',
						'label'     => __('Featured Image Overlay Opacity', 'fl-builder'),
						'default'   => '0.3',
						'size'      => '3'
					),
				),
			),

			'heading_style' => array(
				'title'     => __('Heading Styles', 'fl-builder'),
				'fields'    => array(
					'heading_font' => array(
						'type'          => 'font',
						'label'         => __('Font Family', 'fl-builder'),
						'preview'		=> array(
							'type'		=> 'font',
							'selector'	=> '.single-featured-blog .featured-content h4 a',
						),
					),
					'heading_font_size'  => array(
						'type'        => 'text',
						'label'       => __('Font Size', 'fl-builder'),
						'default'     => '40',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '',
							'property' => 'font-size',
							'unit'     => 'px'
						)
					),
					'headline_color' => array(
						'type'          => 'color',
						'label'         => __('Headline Color', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),
				)
			),

			'featured_post_link' => array(
				'title'          => __('Featured Posts', 'fl-builder'),
				'fields'         => array(

					'featured_link_font' => array(
						'type'          => 'font',
						'label'         => __('Font', 'fl-builder'),
						'preview'		=> array(
							'type'		=> 'font',
							'selector'	=> '.homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service .homepage-services-service-title a',
						),
					),
					'featured_link_font_size'  => array(
						'type'        => 'text',
						'label'       => __('Font Size', 'fl-builder'),
						'default'     => '20',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '',
							'property' => 'font-size',
							'unit'     => 'px'
						)
					),

					'featured_link_color' => array(
						'type'          => 'color',
						'label'         => __('Featured Post Color', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true
					),

					'featured_link_active_bgcolor' => array(
						'type'          => 'color',
						'label'         => __('Featured Post Active Background', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'featured_active_color' => array(
						'type'          => 'color',
						'label'         => __('Featured Post Active Color', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),

					'featured_post_border_color' => array(
						'type'          => 'color',
						'label'         => __('Featured Post Border Bottom', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),

				),
			),

			'featured_post_content' => array(
				'title'          => __('Featured Post Content', 'fl-builder'),
				'fields'         => array(

					'content_font' => array(
						'type'          => 'font',
						'label'         => __('Font', 'fl-builder'),
						'preview'		=> array(
							'type'		=> 'font',
							'selector'	=> '.homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service.active .homepage-services-service-inner .homepage-services-service-description',
						),
					),

					'content_font_size'  => array(
						'type'        => 'text',
						'label'       => __('Font Size', 'fl-builder'),
						'default'     => '24',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '.homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service.active .homepage-services-service-inner .homepage-services-service-description',
							'property' => 'font-size',
							'unit'     => 'px'
						)
					),

					'featured_content_color' => array(
						'type'          => 'color',
						'label'         => __('Content Color', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),

					'button_text' => array(
						'type'          => 'text',
						'label'         => __('Button Text', 'fl-builder'),
						'default'       => 'Learn More',
						'size'        => '20',
					),

					'button_color_text' => array(
						'type'          => 'color',
						'label'         => __('Button Text Color', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'button_bg_color' => array(
						'type'          => 'color',
						'label'         => __('Button Background Color', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'button_hover_bg' => array(
						'type'          => 'color',
						'label'         => __('Button Background Hover Color', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'button_border_bottom_color' => array(
						'type'          => 'color',
						'label'         => __('Button Border Bottom Color', 'fl-builder'),
						'default'       => '',
						'show_reset'    => true,
						'show_alpha'    => false
					),
					'featured_button_top_bottom'  => array(
						'type'        => 'text',
						'label'       => __('Font Size', 'fl-builder'),
						'default'     => '10',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '',
							'property' => 'font-size',
							'unit'     => 'px'
						)
					),
					'featured_button_left_right'  => array(
						'type'        => 'text',
						'label'       => __('Font Size', 'fl-builder'),
						'default'     => '20',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '',
							'property' => 'font-size',
							'unit'     => 'px'
						)
					),
				),
			)
		),
	)
));
