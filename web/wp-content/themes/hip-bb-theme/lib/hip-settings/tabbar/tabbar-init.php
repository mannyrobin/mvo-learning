<?php

require_once __DIR__ . '/inc/Settings.php';
require_once __DIR__ . '/inc/SettingsPage.php';
require_once __DIR__ . '/inc/API.php';
require_once __DIR__.'/../helpers/PHPColors.php';

use Helpers\PHPColors as PHPColors;

class Tabbar
{
	protected $assets;
	
	public function __construct()
	{
		$this->assets = get_template_directory_uri() . '/dist/';
		add_action('init', [ $this, 'init' ]);
		add_action('rest_api_init', [ $this, 'rest_init' ]);
		add_shortcode('hip_tabbar', [ $this, 'render' ]);
	}
	
	public function init()
	{
		if (is_admin()) {
			new Tabbar\SettingsPage($this->assets);
		}
		
		register_nav_menus([
			'tab_1'	=> 'Tab Bar -- Far Left',
			'tab_2'	=> 'Tab Bar -- Center Left',
			'tab_3'	=> 'Tab Bar -- Center Right',
			'tab_4'	=> 'Tab Bar -- Far Right'
		]);
	}
	
	public function rest_init()
	{
		$api = new Tabbar\API();
		$api->addRoutes();
	}
	
	public function render()
	{
		$settings = Tabbar\Settings::getSettings();
		ob_start();
		?>
		<div class="tabbar-wrapper">
			<style>
				@media screen and ( min-width: <?php echo $settings['max_width'] + 1; ?>px ) {
					.tabbar-wrapper { display: none; }
				}
				
				.tabbar {
					border-top: 1px solid <?php echo $settings['selected_color'] ?>;
				}
				
				.tabbar .tab {
					background-color: <?php echo $settings['bg_color'] ?>;
					color: <?php echo $settings['fg_color'] ?>;
					border-right: 1px solid <?php echo $settings['selected_color'] ?>;
				}
				
				.tabbar .tab button, .tabbar .tab button svg {
					background-color: <?php echo $settings['bg_color'] ?>;
					color: <?php echo $settings['fg_color'] ?>;
					fill: <?php echo $settings['fg_color'] ?>;
				}
				
				.tabbar .tab, .tabbar .tab.selected button {
					background-color: <?php echo $settings['selected_color'] ?>;
				}
				
				.c-hamburger span, .c-hamburger span:before, .c-hamburger span:after {
					background: <?php echo $settings['fg_color'] ?>;
				}	
				
				.tabbar .tab div.tabbar-menu {
					background: <?php echo $settings['bg_color'] ?>;
				}
				
				.tabbar .tab div.tabbar-menu ul li a {
					color: <?php echo $settings['fg_color'] ?>;
				}
				
				.tabbar .tab div.tabbar-menu ul li {
					border-bottom: 1px solid <?php echo $settings['fg_color'] ?>;
				}
				
				.tabbar .tab div.tabbar-menu  ul  li  ul {
					background: <?php echo $settings['selected_color'] ?>;
				}
				
				.tabbar .tab div.tabbar-menu  ul  li  ul  li  ul {
					background: <?php echo $settings['bg_color'] ?>;
				}
				.tabbar .tab div.tabbar-menu .search-bar{
					background: <?php echo $settings['bg_color'] ?>;
				}
				.tabbar .tab div.tabbar-menu .search-bar input{
					background:  <?php echo empty($settings['search_bg']) ? $this->_get_search_bg($settings['bg_color']) : $settings['search_bg']; ?>;
				}
				.tabbar .tab div.tabbar-menu .search-bar #searchsubmit{
					color:  <?php echo !empty($settings['search_btn_color']) ? $settings['search_btn_color'] : $settings['fg_color']  ?>;
				}
                .tabbar-wrapper .tabbar .tab div.tabbar-menu li.menu-item-has-children:after{
                    color: <?php echo $settings['fg_color']; ?>
                }
                body.logged-in.admin-bar .tabbar-wrapper .tabbar .tab.selected div.tabbar-menu{
                    height: calc(100% - 106px);
                }
			</style>
			<div class="tabbar">
				<?php
				foreach ($settings['tab'] as $index => $tab) : ?>
					<div class="tab">
						<button class="tabbar-button" type="button" 
							<?php if ($tab['type'] == 'link') :
								echo ' data-url="' . $tab['link'] . '" ';
							else :
								echo ' ';
							endif; ?>
						>
							<?php if ($tab['button'] == 'hamburger') : ?>
								<p class="c-hamburger c-hamburger--htx"><span></span></p>
							<?php else : ?>
								<span class="svg-wrap">
									<?php echo $tab['svg'] ?>
								</span>
							<?php endif; ?>
							<span class="label"><?php echo $tab['name'] ?></span>
						</button>
						<?php if ($tab['type'] == 'menu') :
							$tabNum = $index + 1; ?>
							<div class="tabbar-menu">
								<?php if ($settings['enable_search']) :?>
									<div class="search-bar">
										<?php get_search_form();?>
									</div>
								<?php endif;?>
								<?php wp_nav_menu([ 'theme_location' => "tab_$tabNum" ]); ?>
							</div>

						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div> <?php
		
		return ob_get_flush();
	}


	/**
	 * get 20% darker color
	 * @param string
	 * @return string
	 */
	private function _get_search_bg($bg_color)
	{
		$search_bg = new PHPColors\Color($bg_color);
		return '#'.$search_bg->darken(20);
	}
}

$tabbar = new Tabbar();
