<?php
global $post;
$args = array();
$args['post_type'] = 'staff';
if (!empty($settings->match_staff_categories)) {
	if ($settings->match_staff_categories == 'match') {
		$args['tax_staff_staff_category_matching'] = '1';
	} else {
		$args['tax_staff_staff_category_matching'] = '0';
	}
}
if (!empty($settings->staff_categories)) {
	$args['tax_staff_staff_category'] = $settings->staff_categories;
}
$args['posts_per_page'] = '-1';
$args['order_by'] = 'rand';

$staffs = FLBuilderLoop::query((object)$args);
?>
<div class="staff-slider" itemscope="itemscope" itemtype="http://schema.org/Blog">
	<div class="staff-slider-wrapper">
		<?php if($staffs->have_posts()): while ($staffs->have_posts()) :  $staffs->the_post();?>
			<div class="staff-slider-post">
				<?php if(has_post_thumbnail()): ?>
					<div class="staff-image" style="background-image:url('<?php echo get_the_post_thumbnail_url( $post->ID , 'full') ?>');">
					</div>
				<?php endif; ?>
				<div class="staff-content-wrapper">
					<div class="staff-content">
						<?php if(!empty($settings->headline)): ?>
							<h2 class="staff-heading"><?php echo $settings->headline; ?></h2>
						<?php endif; ?>
						<div class="staff-image-sm">
							<img src="<?php echo get_the_post_thumbnail_url( $post->ID , 'full') ?>" />
						</div>
						<div class="staff-details">
							<h3 class="staff-name"><?php the_title(); ?></h3>
							<p class="staff-bio"><?php echo wp_trim_words( get_the_excerpt(), $num_words = !empty($settings->desc_length) ? $settings->desc_length : 30, $more = null );?></p>
						</div>
						<div class="staff-more-button">
							<a class="button solid-button" href="<?php the_permalink(); ?>">
								<?php echo (!empty($settings->button_text) ? $settings->button_text : 'Learn More'); ?>
							</a>
						</div>
					</div>
					<?php
					// Render the navigation.
					if( $settings->navigation == 'yes' ) : ?>
						<div class="fl-post-slider-navigation" aria-label="post slider buttons">
							<a class="slider-prev" href="#" aria-label="previous" aria-role="button"><i class="fa fa-caret-left" aria-hidden="true"></i></a>
							<a class="slider-next" href="#" aria-label="next" aria-role="button"><i class="fa fa-caret-right" aria-hidden="true"></i></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endwhile; endif;?>
	</div>
</div>
<div class="fl-clear"></div>

<?php wp_reset_postdata(); ?>
