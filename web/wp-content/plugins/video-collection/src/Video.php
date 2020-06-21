<?php

namespace HipVideoCollection;

class Video
{
	public $id;
	public $title;
	public $embed;
	public $screenshot;
	public $default_screenshot;
	private $settings;
	private $api_key;
	private $video_info;
	private $padding;

	public function __construct($args = [])
	{
		extract($args);
		$this->id = (isset($id)) ? $id : false;
		$this->title = (isset($title)) ? $title : false;
		$this->embed = (isset($embed)) ? $embed : false;
		$this->screenshot = (isset($screenshot)) ? $screenshot : false;
		$this->default_screenshot = (isset($default_screenshot)) ? $default_screenshot : false;
		$this->settings = Settings::getSettings();
		$this->api_key = !empty($this->settings['youtube_api_key']) ? $this->settings['youtube_api_key'] : '';
		$this->padding = (isset($padding)) ? $padding : false;
	}

	public static function validateURL($url = null)
	{
		if (!$url) {
			if (!$url = $this->embed) {
				return false;
			}
		}
		return preg_match('@^https://youtube.com/embed@', $url)
			|| preg_match('@^https://youtu.be/@', $url);
	}

	public function getDefaultScreenshot()
	{
		$vidId = $this->getVideoId();

		if (!$vidId) {
			return false;
		}
		$video_info = $this->_getVideoInfo($vidId);
		if (!empty($video_info)) {
			if (!empty($video_info->items[0]->snippet->thumbnails)) {
				$thumbs = $video_info->items[0]->snippet->thumbnails;
				if (!empty($thumbs->maxres)) {
					return $thumbs->maxres->url;
				} elseif (!empty($thumbs->standard)) {
					return $thumbs->standard->url;
				} elseif (!empty($thumbs->high)) {
					return $thumbs->high->url;
				} else {
					return $thumbs->default->url;
				}
			}
		}

		return "https://img.youtube.com/vi/$vidId/maxresdefault.jpg";
	}

	public function getPublishedDate()
	{
		$vidId = $this->getVideoId();

		if (!$vidId) {
			return false;
		}

		$video_info = $this->_getVideoInfo($vidId);
		if (!empty($video_info)) {
			if (!empty($video_info->items[0]->snippet->publishedAt)) {
				return $video_info->items[0]->snippet->publishedAt;
			}
		}

		return false;
	}

	public function getVideoId()
	{
		if (!$this->embed) {
			return false;
		}

		$pattern = '@.+\/([a-zA-Z0-9_\-]+)\/*$@';

		preg_match($pattern, $this->embed, $matches);

		return $matches[1];
	}

	public function getIFrame($instance)
	{
		$frame = '<div class="hvc-video" style="padding-bottom:';
		$frame .= $this->getVideoPadding() . '%">';
		$frame .= '<iframe id="iframe-' . $instance . '" type="text/html" width="640" height="360" src="https://www.youtube.com/embed/' . $this->getVideoId() . '?enablejsapi=1&rel=0"></iframe>';
		$frame .= '</div>';
		return $frame;
	}

	public function getFrontend($show_title = 1, $title_pos = 'bottom', $show_description = false)
	{
		$instance = uniqid();
		$post = get_post($this->id);
		$video_description = $post->post_content;
		include HVC_PATH . '/templates/video.php';
	}

	public static function getVideo($post_id)
	{
		if ($post_id == 0) {
			return false;
		}
		$title = get_post_meta($post_id, '_pvc_display_title', true);

		if (!$title) {
			$title = get_the_title($post_id);
		}
		return new Video([
			'id'                 	=> $post_id,
			'title'              	=> $title,
			'embed'              	=> get_post_meta($post_id, '_pvc_video_embed', true),
			'screenshot'         	=> get_post_meta($post_id, '_pvc_screenshot', true),
			'default_screenshot' 	=> get_post_meta($post_id, '_pvc_default_screenshot', true),
			'padding'				=> get_post_meta($post_id, '_hvc_video_responsive_padding', true)
		]);
	}

	public static function addVideo($params = [])
	{
		$post_args = [
			'post_type'   => $params['type'],
			'post_title'  => $params['title'],
			'post_status' => 'publish',
			'ID'          => $params['id']
		];

		$id = wp_insert_post($post_args);

		update_post_meta($id, '_pvc_display_title', $params['title']);
		update_post_meta($id, '_pvc_video_embed', $params['embed']);
		update_post_meta($id, '_pvc_screenshot', $params['screenshot']);
		update_post_meta($id, '_pvc_default_screenshot', $params['default_screenshot']);
		update_post_meta($id, '_hvc_video_responsive_padding', $params['padding']);
	}

	public function getVideoPadding()
	{
		if ($this->padding) {
			return $this->padding;
		}

		$videoInfo = $this->_getVideoInfo($this->getVideoId());
		$padding = 56.25;
		if (!empty($videoInfo->items[0]->player)) {
			$padding = ($videoInfo->items[0]->player->embedHeight / $videoInfo->items[0]->player->embedWidth) * 100;
		}

		update_post_meta($this->id, '_hvc_video_responsive_padding', $padding);

		$this->padding = $padding;
		return $padding;
	}

	private function _getVideoInfo($video_id)
	{
		if (!empty($this->video_info)) {
			return $this->video_info;
		}
		$embed_max_width = $this->settings['embed_max_width'] ? $this->settings['embed_max_width'] : 900;
		if (!empty($this->api_key)) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key=' .$this->api_key. '&part=snippet,player&maxWidth='.$embed_max_width);
			if (defined('WP_ENV')) {
				if (WP_ENV == 'development') {
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				}
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$output = curl_exec($ch);
			if ($output === false) {
				return 'curl_error ' . curl_error($ch);
			}
			curl_close($ch);
			$this->video_info = json_decode($output);
			return $this->video_info;
		}

		return false;
	}
}
