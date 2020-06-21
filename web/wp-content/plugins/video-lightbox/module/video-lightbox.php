<?php 

namespace BBVL\Module;

class VideoLightbox extends \FLBuilderModule
{
	public function __construct()
	{
		parent::__construct( [
			'name'						=> __( 'Video Lightbox', 'bbvl' ),
			'description'			=> __( 'Adds a video player inside a lightbox', 'bbvl' ),
			'category'				=> 'Hip Modules',
			'dir'							=> VIDEO_LIGHTBOX_DIR,
			'url'							=> VIDEO_LIGHTBOX_URL,
			'partial_refresh' => true
		] );
		
		$this->add_css( 'font-awesome' );
		$this->add_css( 'jquery-magnificpopup' );
		$this->add_js( 'jquery-magnificpopup' );
	}
	
	public function getColor( $color ) {
		if ( strlen($color) == 6 ) {
			return '#' . $color;
		} else {
			return $color;
		}
	}
	
 	public function update( $settings ) 
 	{	
		if ( 'youtube' == $settings->embed_type ) {
			$settings->video_object = new \BBVL\YoutubeVideo( $settings->youtube_embed, $this->node );
		}
		
 		return $settings;
 	}
}

\FLBuilder::register_module( 'BBVL\Module\VideoLightbox', [
	'video'	=> [
		'title'	=> __( 'Video', 'bbvl' ),
		'sections'	=> [
			'embed'			=> [
				'title'			=> __( 'Video', 'bbvl' ),
				'fields'		=> [
					'embed_type'		=> [
						'type'					=> 'select',
						'label'					=> __( 'Type of embed', 'bbvl' ),
						'default'				=> 'youtube',
						'options'				=> [
							'youtube'				=> __( 'YouTube', 'bbvl' )
						],
						'toggle'				=> [
							'youtube'				=> [
								'fields'				=> [
									'youtube_embed'
								]
							],
							'manual'				=> [
								'fields'				=> [
									'manual_embed'
								]
							]
						]
					],
					'youtube_embed'	=> [
						'type'					=> 'text',
						'label'					=> __( 'YouTube Embed URL', 'bbvl' ),
						'description'		=> __( 'Example: https://youtu.be/cGVdCGxh1IY', 'bbvl' )
					],
					'manual_embed'	=> [
						'type'					=> 'code',
						'label'					=> '',
						'wrap'					=> true,
						'editor'				=> 'html',
						'rows'					=> '9',
						'connections'		=> [ 'custom_field' ],
						'description'		=> __( 'Copy your embed code here.', 'bbvl' )
					]
				]
			],
			'preview'		=> [
				'title'			=> __( 'Preview', 'bbvl' ),
				'fields'		=> [
					'preview'				=> [
						'type'					=> 'photo',
						'label'					=> __( 'Preview Image', 'bbvl' ),
						'show_remove'		=> true,
						'description'		=> __( 'If no image is selected, a generated screenshot will be used.' )
					]
				]
			]
		]
	],
	'style'	=> [
		'title'	=> __( 'Style', 'bbvl' ),
		'sections'	=> [
			'preview'		=> [
				'title'			=> __( 'Preview Styles', 'bbvl' ),
				'fields'		=> [
					'icon_bg'					=> [
						'type'						=> 'color',
						'label'						=> __( 'Icon Background Color', 'bbvl' ),
						'default'					=> 'FFFFFF',
						'show_reset'			=> true,
						'show_alpha'			=> true
					],
					'icon_hover_bg'		=> [
						'type'						=> 'color',
						'label'						=> __( 'Icon Background Color (on Hover)', 'bbvl' ),
						'default'					=> '01caf8',
						'show_reset'			=> true,
						'show_alpha'			=> true
					],
					'icon_color'			=> [
						'type'						=> 'color',
						'label'						=> __( 'Icon Color', 'bbvl' ),
						'default'					=> '444444',
						'show_reset'			=> true,
						'show_alpha'			=> true
					],
					'icon_hover_color'=> [
						'type'						=> 'color',
						'label'						=> __( 'Icon Color (on Hover)', 'bbvl' ),
						'default'					=> '444444',
						'show_reset'			=> true,
						'show_alpha'				=> true
					],
					'pulse'						=> [
						'type'						=> 'select',
						'label'						=> __( 'Pulse Effect', 'bbvl' ),
						'default'					=> 'off',
						'options'					=> [
							'on'							=> __( 'On', 'bbvl' ),
							'off'							=> __( 'Off', 'bbvl' )
						]
					],
					'overlay_color'		=> [
						'type'						=> 'color',
						'label'						=> __( 'Overlay Color', 'bbvl' ),
						'default'					=> '',
						'show_reset'			=> true,
						'show_alpha'				=> true
					],
					'overlay_hover'		=> [
						'type'						=> 'color',
						'label'						=> __( 'Overlay Color (on Hover)', 'bbvl' ),
						'default'					=> '',
						'show_reset'			=> true,
						'show_alpha'				=> true
					]
				]
			],
			'lightbox'	=> [
				'title'			=> __( 'Lightbox Styles', 'bbvl' ),
				'fields'		=> [
					'close_pos'				=> [
						'type'						=> 'select',
						'label'						=> __( 'Close Button Position', 'bbvl' ),
						'default'					=> 'top_out_right',
						'options'					=> [
							'top_out_right'		=> __( 'Top Outside Right', 'bbvl' ),
							'bottom_out_right'=> __( 'Bottom Outside Right', 'bbvl' ),
							'top_out_left'		=> __( 'Top Outside Left', 'bbvl' ),
							'bottom_out_left'	=> __( 'Bottom Outside Left', 'bbvl' ),
							'top_in_right'		=> __( 'Top Inside Right', 'bbvl' ),
							'bottom_in_right'	=> __( 'Bottom Inside Right', 'bbvl' ),
							'top_in_left'			=> __( 'Top Inside Left', 'bbvl' ),
							'bottom_in_left'	=> __( 'Bottom Inside Left', 'bbvl' )
						]
					],
					'close_bg'				=> [
						'type'						=> 'color',
						'label'						=> __( 'Close Button Background Color', 'bbvl' ),
						'default'					=> '444444',
						'show_reset'			=> true,
						'show_alpha'				=> true
					],
					'close_hover_bg'	=> [
						'type'						=> 'color',
						'label'						=> __( 'Close Button Background Color (on Hover)', 'bbvl' ),
						'default'					=> '444444',
						'show_reset'			=> true,
						'show_alpha'				=> true
					],
					'close_color'			=> [
						'type'						=> 'color',
						'label'						=> __( 'Close Button Color', 'bbvl' ),
						'default'					=> 'FFFFFF',
						'show_reset'			=> true,
						'show_alpha'				=> true
					],
					'close_hover'			=> [
						'type'						=> 'color',
						'label'						=> __( 'Close Button Color (on Hover)', 'bbvl' ),
						'default'					=> 'FFFFFF',
						'show_reset'			=> true,
						'show_alpha'				=> true
					]
				]
			]
		]
	]
] );
