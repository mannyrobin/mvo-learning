<?php
$args = array();
$args['number'] = !empty($settings->number_of_categories) ? $settings->number_of_categories : 0;
$args['hide_empty'] = true;
if(!empty($settings->match_post_categories)) {
	if ($settings->match_post_categories === 'include') {
		$args['include'] = $settings->categories;
	}
	if ($settings->match_post_categories === 'exclude') {
		$args['exclude'] = $settings->categories;
	}
}
$args['orderby'] = 'count';
$args['order'] = 'DESC';
$args['fields'] = 'id=>name';
?>
<div class="hip-categories-wrapper">
	<div class="heading">
		<h3><?php echo !empty($settings->heading) ? $settings->heading : 'Categories';?></h3>
	</div>
	<div class="categories-list">
		<ul>
			<?php foreach (get_categories($args) as $id=>$name) : ?>
				<li>
					<a href="<?php echo get_term_link($id)?>"><?php echo $name; ?></a>
				</li>
			<?php endforeach;?>
		</ul>
	</div>
</div>