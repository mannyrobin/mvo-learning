<?php

$args = array(
	'post_type'   =>  'services',
	'posts_per_page'    => $settings->featured_post_number,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'meta_query' => array(
		array(
			'key' => 'featured_service',
			'value' => '1',
			'compare' => 'like'
		)
	)
);

global $hipServices;

$services = get_posts($args);
?>
<div class="homepage-services-wrap">
	<div class="homepage-services-inner-wrap">
		<div class="homepage-services-inner-inner-wrap">
			<h1 class="homepage-services-headline">
					<?php echo $settings->headline; ?>
			</h1>
			<div class="homepage-services-services-inner-wrap">
				<?php foreach ($services as $service) :
					$excerpt_text = get_the_excerpt($service);
					?>

					<div class="homepage-services-service">
						<div class="homepage-services-service-title">
								<a href="<?php echo get_the_permalink($service) ?>">
										<span><?php echo get_the_title($service) ?></span>
										<img class="service-arrow" src="<?php echo $hipServices['url'] . '/images/arrow.svg' ?>">
								</a>
						</div>
						<div class="homepage-services-service-inner">
							<div class="homepage-services-service-description">
									<?php echo $excerpt_text; ?>
							</div>
							<div class="homepage-services-service-button">
								<a class="button button-primary"
										href="<?php echo get_the_permalink($service) ?>">
										<?php echo $settings->button_text ? $settings->button_text : 'LEARN MORE' ?>
								</a>
							</div>
						</div>
						<div class="homepage-services-service-image">
							<?php echo get_the_post_thumbnail($service, 'extra-large'); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php wp_reset_postdata();?>
