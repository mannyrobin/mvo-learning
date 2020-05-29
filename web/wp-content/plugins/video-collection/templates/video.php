<div class="pps-video-wrap">
	<?php if (($show_title == 'true' || $show_title == "1") && ($title_pos == 'top')) : ?>
		<h3 class="pps-video-preview-title">
			<?php if (!is_single()) : ?>
				<a href="<?php echo get_permalink($this->id) ?>">
					<?php echo $this->title ?>
				</a>
			<?php else : ?>
				<?php echo $this->title ?>
			<?php endif; ?>
		</h3>
	<?php endif; ?>
	<div class="pps-video-preview-wrap">
		<a href="#vidpopup-<?php echo $instance ?>" id="preview-<?php echo $instance ?>" class="preview">
			<?php if ($this->screenshot) :
				echo wp_get_attachment_image($this->screenshot, 'pvc_preview@2x');
			else : ?>
				<img src="<?php echo $this->default_screenshot ?>" alt="<?php $this->title ?>">
			<?php endif; ?>
			<span class="push-btn">
				<i class="fa fa-play"></i>
			</span>
		</a>
	</div>
	<?php if (($show_title == 'true' || $show_title == "1") && ($title_pos == 'bottom')) : ?>
		<h3 class="pps-video-preview-title">
			<?php if (!is_single()) : ?>
				<a href="<?php echo get_permalink($this->id) ?>">
					<?php echo $this->title ?>
				</a>
			<?php else : ?>
				<?php echo $this->title ?>
			<?php endif; ?>
		</h3>
	<?php endif; ?>
	<?php
	if ($show_description) {
		echo $video_description;
	}
	?>
</div>

<div id="vidpopup-<?php echo $instance ?>" class="pvc-lightbox">
	<h2 class="pps-video-title"><?php echo $this->title ?></h2>
	<?php echo $this->getIFrame($instance); ?>
	<div class="vidpopup-description">
			<?php
			if ($show_description) {
				echo $video_description;
			}
			?>
	</div>
</div>

<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "VideoObject",
	"name": "<?php echo $this->title ?>",
	"description": "<?php echo addslashes($video_description) ?>",
	"thumbnailUrl": "<?php echo ($this->screenshot) ? wp_get_attachment_image_url($this->screenshot) : $this->default_screenshot ?>",
	"embedUrl": "<?php echo $this->embed ?>",
	"uploadDate": "<?php echo $this->getPublishedDate(); ?>"
}
</script>
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$('a#preview-<?php echo $instance ?>').popup({
			backClass: 'vid_popup_back',
			containerClass: 'vid_popup_cont',
			afterOpen: function () {
				var player = new YT.Player('iframe-<?php echo $instance ?>', {
					events: {
						'onReady': onPlayerReady
					}
				});
				function onPlayerReady(event) {
					if (!(/Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent))) {
						event.target.playVideo();
					}
				}
			}
		});
	});
</script>
	
