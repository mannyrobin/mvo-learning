<?php

namespace HipVideoCollection;

class HVCVideoGalleryModule extends \FLBuilderModule
{
	public function __construct()
	{
		parent::__construct([
			'name'        => 'Video Gallery from collection',
			'description' => 'Display a single video from collection.',
			'category'    => 'Hip Modules',
			'dir'         => HVC_PATH . '/module/video-gallery/',
			'url'         => HVC_URL . '/module/video-gallery/'
		]);
		$this->icon = $this->moduleIcon();
	}
	public function moduleIcon($icon = '')
	{
		return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  width="20" height="20" viewBox="0 0 51.802 51.801">
            <g>
                <g>
                    <path d="M47.947,4.43H12.495c-2.126,0-3.855,1.729-3.855,3.854v2.641H8.174c-2.125,0-3.855,1.728-3.855,3.854v2.642H3.854
                        C1.729,17.421,0,19.15,0,21.275v22.242c0,2.125,1.729,3.854,3.854,3.854h35.453c2.127,0,3.855-1.729,3.855-3.854v-2.644h0.465
                        c2.125,0,3.854-1.728,3.854-3.854v-2.641h0.467c2.125,0,3.854-1.729,3.854-3.854V8.284C51.803,6.159,50.074,4.43,47.947,4.43z
                         M39.197,30.417v3.963v2.531v3.963v2.533H3.963V21.385h0.356h3.964H8.64h3.964h26.593V30.417z M43.518,36.911h-0.355v-2.531
                        v-3.963v-9.142c0-2.125-1.729-3.854-3.855-3.854H12.604V17.42H8.641v-1.266H8.284v-1.266h0.357h3.963h2.574h27.985h0.356v15.526
                        v3.963v2.533H43.518z M47.839,30.417h-0.356V14.78c0-2.126-1.729-3.854-3.854-3.854H12.604V8.394H47.84L47.839,30.417
                        L47.839,30.417z"/>
                    <path d="M26.401,30.446l-5.788-4.215c-0.583-0.424-1.354-0.484-1.997-0.158c-0.642,0.327-1.047,0.986-1.047,1.707v8.43
                        c0,0.722,0.405,1.381,1.047,1.707c0.274,0.141,0.572,0.209,0.869,0.209c0.398,0,0.794-0.125,1.128-0.367l5.788-4.215
                        c0.494-0.36,0.787-0.938,0.787-1.549C27.188,31.382,26.896,30.806,26.401,30.446z"/>
                </g>
            </g>
            </svg>';
	}
	public static function totalVideos()
	{
		return count(VideoCollection::$all_posts);
	}
}

\FLBuilder::register_module('\HipVideoCollection\HVCVideoGalleryModule', [
	'general' => array(
		'title'    => __('General', 'fl-builder'),
		'sections' => array(
			'general' => array(
				'title'  => __('Gallery Settings', 'fl-builder'),
				'fields' => array(
					'match_video_categories' => array(
						'type'         => 'select',
						'label'        => __('Video Categories', 'fl-builder'),
						'default'      => 'match',
						'size' => 100,
						'options'      => array(
							'match' => 'Match these video categories',
							'exclude' => 'Exclude these video categories'
						)
					),
					'video_categories' => array(
						'type'          => 'suggest',
						'label'         => __(' ', 'fl-builder'),
						'action'        => 'fl_as_terms',
						'data'          => 'video-category',
					),
					'video_per_page' => array(
						'type'        => 'text',
						'label'       => __('Number of Videos', 'fl-builder'),
						'size'        => '3',
						'description' => __('<br>Number of total videos is ' . \HipVideoCollection\HVCVideoGalleryModule::totalVideos(), 'fl-builder'),
						'help'        => __('Leave empty to select all', 'fl-builder'),
					),
					'video_order_by' => array(
						'type'    => 'select',
						'label'   => __('Order By', 'fl-builder'),
						'default' => '',
						'options' => [
							'menu_order' => __('Menu Order', 'fl-builder'),
							'date'       => __('Date', 'fl-builder'),
							'id'         => __('ID', 'fl-builder')
						]
					),
					'video_order'    => array(
						'type'    => 'select',
						'label'   => __('Order', 'fl-builder'),
						'default' => '',
						'options' => [
							'desc' => __('DESC', 'fl-builder'),
							'asc'  => __('ASC', 'fl-builder'),
						]
					)
				)
			)
		)
	),
]);
