<?php

namespace HipVideoCollection\Background;

class AddPadding extends \WP_Background_Process
{
	
	protected $action = "video_collection_add_padding";

	protected function task($item)
	{
		$padding = $item->getVideoPadding();
		error_log("Video Padding Added: $padding");
		return false;
	}
}
