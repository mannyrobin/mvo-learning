<?php

namespace Hip\Services;

class FeaturedPostMeta
{
	
	/*
	* cpt featured post metabox register
	*/
	public function cpt_featuredpost_metabox()
	{
		add_meta_box(
			'featured_post_metabox',
			'Featured Post',
			array($this, 'cpt_featuredpost_display_metabox'),
			'services',
			'side',
			'high'
		);
	}

	/*
		* cpt featured post metabox display in post
		*/
	public function cpt_featuredpost_display_metabox($post)
	{
			$is_featured_service = get_post_meta($post->ID)['featured_service'][0];
		?>

			<div class="cpt-featured-content">
					<div class="cpt-featured-item">
							<input type="checkbox" name="featured_service" id="cpt_featuredmeta" value="1" <?php checked($is_featured_service, 1);?> />
							<label for="cpt_featuredmeta"><strong><?php _e('Feature this post', 'cpt')?></strong></label>
					</div>
			</div>
			<?php
	}

	public function cpt_featuredpost_metabox_save($post_id)
	{

			// Checks save status
			$is_autosave = wp_is_post_autosave($post_id);
			$is_revision = wp_is_post_revision($post_id);
			$is_valid_nonce = ( isset($_POST[ 'sm_nonce' ]) && wp_verify_nonce($_POST[ 'sm_nonce' ], basename(__FILE__)) ) ? 'true' : 'false';

			// Exits script depending on save status
		if ($is_autosave || $is_revision || !$is_valid_nonce) {
				return;
		}

			// Checks for input and saves
		if (isset($_POST[ 'featured_service' ])) {
				update_post_meta($post_id, 'featured_service', true);
		} else {
				update_post_meta($post_id, 'featured_service', false);
		}
	}
}
