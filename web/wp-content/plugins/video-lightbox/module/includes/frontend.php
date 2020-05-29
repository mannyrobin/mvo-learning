<?php 
global $wp_embed; 

if ( 'youtube' == $settings->embed_type ) {
	$href = $settings->video_object->getVideoLink();
	if ( !empty($settings->preview) ) {
		$preview = $settings->preview_src;
	} else {
		$preview = $settings->video_object->getDefaultScreenshot();
	}
} else {
	$href = $settings->manual_embed;
	$preview = $settings->preview_src;
}

?>

<div class="bbvl-preview-wrap">
	<a class="bbvl-preview" href="<?php echo $href ?>">
		<div class="bbvl-preview-image">
			<img src="<?php echo $preview ?>" />
		</div>
		<div class="bbvl-preview-icon">
			<i class="fa fa-play"></i>
		</div>
	</a>
</div>

	
