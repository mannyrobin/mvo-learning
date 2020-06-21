<?php

/*generate arguments for query posts*/
$args = array();
$args['post_type'] = 'post';
if ($settings->display_by == 'category') {
    $args['posts_per_page'] = intval($settings->number_of_posts);
    $args['cat'] = $settings->selected_category;
}
if ($settings->display_by == 'post') {
    $args['posts_per_page'] = -1;
    $args['post__in'] = $settings->selected_posts;
}
$args['orderby'] = $settings->order_by == 'def' ? 'date' : $settings->order_by;
$args['order'] = $settings->order == 'def' ? 'DESC' : $settings->order;
/*Query posts*/
$query = new WP_Query($args);
?>
    <div class="rp-wrapper <?php echo $settings->layout == 'aside' ? 'aside' : ''; ?>">
        <div class="rp-heading-wrap">
            <h1 class="rp-heading"><?php echo $settings->heading; ?></h1>
        </div>
        <?php if ($settings->layout === 'main'): ?>
            <p class="rp-summery"> <?php echo $settings->summery_text; ?> </p>
        <?php endif; ?>
        <?php if ($query->have_posts()): ?>
            <ul class="rp-posts">
                <?php while ($query->have_posts()): $query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No Posts Found</p>
        <?php endif; ?>
    </div>
<?php wp_reset_postdata(); ?>