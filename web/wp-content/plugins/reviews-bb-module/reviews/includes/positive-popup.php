<div class="before-logos">
    <?php echo $settings->positive_intro; ?>
</div>

    <div class="logos large-logos">
        <?php foreach( $settings->review_site as $key=>$site ) : ?>
            <?php if($site->featured): ?>
            <div class="review-popup-logo large-logo">
                <a class="popup" href="#instructions-<?php echo $key; ?>"><?php echo wp_get_attachment_image( $site->logo, 'full' ); ?></a>
            </div>
        <?php endif; endforeach; ?>
    </div>
    <div class="logos small-logos">
        <?php foreach( $settings->review_site as $key=>$site ) : ?>
            <?php if(!$site->featured): ?>
                <div class="review-popup-logo small-logo">
                    <a class="popup" href="#instructions-<?php echo $key; ?>"><?php echo wp_get_attachment_image( $site->logo, 'full' ); ?></a>
                </div>
        <?php endif; endforeach; ?>
    </div>