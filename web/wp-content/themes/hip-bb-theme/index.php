<?php

get_header();

do_action('hip_bb_banner');
do_action('hip_bb_breadcrumbs');
?>
<article class="main-content">
	<?php if (have_posts()) :
		while (have_posts()) :
			the_post();
			the_content();
		endwhile;
	endif; ?>
</article>
<?php
do_action('hip_bb_after_content');

get_footer();
