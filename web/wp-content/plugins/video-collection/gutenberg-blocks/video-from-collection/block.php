<?php

namespace HipVideoCollection;

class VideoFromCollectionBlock
{

	public function __construct()
	{
		add_action('init', array($this,'initBlock'));
	}

	public function initBlock()
	{
		wp_enqueue_script('pvc-popup-script', HVC_URL . '/assets/frontend.js', ['jquery'], HVC_VERSION, true);

		wp_register_script('hvc-video-block-script', plugins_url('block.js', __FILE__), array( 'jquery','wp-blocks', 'wp-element', 'wp-i18n' ), HVC_VERSION, true);
		// Styles.
		wp_register_style('hvc-video-block-editor-style', plugins_url('editor.css', __FILE__), array( 'wp-edit-blocks' ));

		register_block_type('hvc-video-block/video-from-collection', array(
			'editor_script' => 'hvc-video-block-script',
			'editor_style' => 'hvc-video-block-editor-style'
		));

		wp_localize_script('hvc-video-block-script', 'blockInfo', array(
			'assetsUrl'=> HVC_URL.'/assets/',
			'restUrl' => rest_url('wp/v2/hip_video_collection?per_page='.wp_count_posts('hip_video_collection')->publish)
		));
	}
}
