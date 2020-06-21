<?php

namespace HipVideoCollection;

class BBModule extends \FLBuilderModule
{
	public function __construct()
	{
		parent::__construct([
			'name'        => 'Video from Collection',
			'description' => 'Display a single video from collection.',
			'category'    => 'Hip Modules',
			'dir'         => HVC_PATH . '/module/single-video/',
			'url'         => HVC_URL . '/module/single-video/'
		]);
		$this->icon = $this->moduleIcon();
	}

	public function moduleIcon($icon = '')
	{
		return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 60 60">
        <path d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M45.563,30.826l-22,15
            C23.394,45.941,23.197,46,23,46c-0.16,0-0.321-0.038-0.467-0.116C22.205,45.711,22,45.371,22,45V15c0-0.371,0.205-0.711,0.533-0.884
            c0.328-0.174,0.724-0.15,1.031,0.058l22,15C45.836,29.36,46,29.669,46,30S45.836,30.64,45.563,30.826z"/>
        </svg>';
	}

	public static function getOptions()
	{

		$posts = VideoCollection::$all_posts;

		$options = [];

		foreach ($posts as $post) {
			$options[$post->ID] = $post->post_title;
		}

		return $options;
	}
}

\FLBuilder::register_module('\HipVideoCollection\BBModule', [
	'bb-video-tab-1' => array(
		'title'    => __('General', 'fl-builder'),
		'sections' => array(
			'video-section-1' => array(
				'title'  => __('Global Settings', 'fl-builder'),
				'fields' => array(
					'video_id'   => array(
						'type'    => 'select',
						'label'   => __('Video', 'fl-builder'),
						'default' => '',
						'options' => \HipVideoCollection\BBModule::getOptions()
					),
					'show_title' => array(
						'type'    => 'select',
						'label'   => 'Title Position',
						'default' => 'bottom',
						'options' => [
							'bottom' => 'Bottom',
							'top'    => 'Top',
							'hide'   => 'Hide'
						]
					),
					'show_description' => array(
						'type'		=> 'select',
						'label'		=> 'Show Description',
						'default'	=> 'false',
						'options'	=> [
							'true'		=> 'True',
							'false'		=> 'False'
						]
					)
				)
			)
		)
	),
]);