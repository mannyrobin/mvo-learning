<?php
add_shortcode('hero-dropdown', 'hero_dropdown_menu');
function hero_dropdown_menu($atts)
{
	$args = shortcode_atts([
	'default'	=> 'Select One'
	], $atts);
	
	$dropdown = wp_nav_menu([
		'theme_location'		=> 'hero',
		'walker'						=> new Walker_Nav_Menu_Dropdown(),
		'items_wrap'				=> '<div class="hero-dropdown"><form><select onchange="if (this.value) window.location.href=this.value"><option value="" selected="selected" disabled="disabled" data-default="default">'. $args['default'] . '</option>%3$s</select></form></div>',
		'echo'							=> false
	]);
	
	echo $dropdown;
}

add_shortcode('hip_breadcrumbs', function ($atts) {
	global $post;
	
	if ($post) {
		$breadcrumbs = new HipBBTheme\Breadcrumbs($post);
		return $breadcrumbs->render();
	}
});

// Legacy Menu. Don't use for new sites.
add_shortcode('hip-mobile-menu', 'hip_bb_theme_mobile_menu');
function hip_bb_theme_mobile_menu()
{
		?>
		<button class="c-hamburger c-hamburger--htx">
			<span>toggle menu</span>
		</button>
		<div class="mobile-menu-wrap">
			<?php wp_nav_menu([ 'theme_location'=> 'mobile' ]); ?>
		</div>
		<?php
}
