<?php
$args = array();
$args['post_type'] = 'hip_video_collection';
if (!empty($settings->match_video_categories)) {
	if ($settings->match_video_categories == 'match') {
		$args['tax_hip_video_collection_video-category_matching'] = '1';
	} else {
		$args['tax_hip_video_collection_video-category_matching'] = '0';
	}
}
if (!empty($settings->video_categories)) {
	$args['tax_hip_video_collection_video-category'] = $settings->video_categories;
}
if (!empty($settings->video_per_page)) {
	$args['posts_per_page'] = $settings->video_per_page;
} else {
	$args['posts_per_page'] = '-1';
}
$args['order'] = $settings->video_order;
$args['orderby'] = $settings->video_order_by;
$query = FLBuilderLoop::query((object)$args);
?>
<div class="video-gallery-wrapper">
	<?php if ($query->have_posts()) : ?>
		<div class="video-container">
			<?php while ($query->have_posts()) :
				$query->the_post(); ?>
				<div class="video-single-item">
					<?php
					$video = HipVideoCollection\Video::getVideo(get_the_ID());
					echo $video->getFrontend();
					?>
				</div>
			<?php endwhile; ?>
		</div>
		<?php if (!empty($settings->video_per_page)) : ?>
			<div class="fl-builder-pagination">
				<?php FLBuilderLoop::pagination($query); ?>
			</div>
			<div class="load-more-btn">
				<a href="#" class="button-primary">Load More</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php wp_reset_postdata(); ?>
