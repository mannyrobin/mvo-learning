<?php get_header(); ?>
<?php do_action('hip_bb_banner'); ?>
<?php do_action('hip_bb_breadcrumbs'); ?>

<div class="container">
	<?php if (have_posts()) : ?>
		<div class="single-video-container">
			<?php while (have_posts()) :
				the_post(); ?>
				<div class="single-video-item">
					<?php
					$video = HipVideoCollection\Video::getVideo(get_the_ID());
					echo $video->getFrontend(true, 'bottom', true);
					?>
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>
<?php do_action('hip_bb_after_content'); ?>
<style>
	.container .single-video-container {
		text-align: center;
	}

	.container .single-video-container .single-video-item {
		width: 980px;
		max-width: 100%;
		display: inline-block;
		margin: 25px 0;
		box-sizing: border-box;
	}

	@media (max-width: 991px) {
		.container .single-video-container .single-video-item {
			margin: 0;
			padding: 20px;
		}
	}
</style>
<?php get_footer(); ?>
