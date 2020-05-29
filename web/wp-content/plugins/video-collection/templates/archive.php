<?php get_header(); ?>
<?php do_action('hip_bb_banner'); ?>
<?php do_action('hip_bb_breadcrumbs'); ?>
<?php do_action('hvc_after_header'); ?>
<div class="container">
	<?php do_action('hvc_before_archive_loop'); ?>
	<?php if (have_posts()) : ?>
		<div class="video-container">
			<?php while (have_posts()) :
				the_post(); ?>
				<div class="video-single-item">
					<?php
					$video = HipVideoCollection\Video::getVideo(get_the_ID());
					echo $video->getFrontend();
					?>
				</div>
			<?php endwhile; ?>
		</div>
		<div class="hvc-pagination  pagination fl-builder-pagination">
			<?php
			echo paginate_links([
				'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
				'current'   => max(1, get_query_var('paged')),
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list'
			]);
			?>
		</div>
	<?php endif; ?>
</div>
<?php do_action('hip_bb_after_content'); ?>
<?php get_footer(); ?>
