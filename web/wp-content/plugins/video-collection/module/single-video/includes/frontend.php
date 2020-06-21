<?php
$show_title = '';
$title_pos = '';
if ($settings->show_title !== 'hide') {
	if ($settings->show_title == 'bottom') {
		$title_pos = ' title_pos="bottom"';
	} else {
		$title_pos = ' title_pos="top"';
	}
} else {
	$show_title = ' show_title=0';
}

$show_description = ' show_description=' . $settings->show_description;

echo do_shortcode('[hip_video id="' . $settings->video_id . '"' . $show_title . $title_pos . $show_description . ']');
