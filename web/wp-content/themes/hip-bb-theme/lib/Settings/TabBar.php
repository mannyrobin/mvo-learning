<?php

namespace Hip\Theme\Settings;

class TabBar
{
	protected $assets;
	
	public function __construct()
	{
		$this->assets = get_template_directory_uri() . '/dist/';
		$this->settings = TabBar\Settings::getSettings();
		add_action('init', [ $this, 'init' ]);
		add_action('rest_api_init', [ $this, 'rest_init' ]);
		add_shortcode('hip_tabbar', [ $this, 'render' ]);
	}
	
	public function init()
	{
		if (is_admin()) {
			new TabBar\SettingsPage($this->assets);
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
		$api = new TabBar\API();
		$api->addRoutes();
	}
	
	public function render()
	{
		ob_start();
		?>
		<div class="tabbar-wrapper">
			<div class="tabbar">
				<?php
				foreach ($this->settings['tab'] as $index => $tab) : ?>
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
								<?php if(!empty($tab['icon'])): ?>
								<div class="tabbar-icon-wrap">
									<?php if($tab['button'] == 'image') : ?>
										<img src="<?php echo $tab['icon'] ?>" alt="">
									<?php elseif($tab['button'] == 'font-awesome') : ?>
										<i class="<?php echo $tab['icon'] ?>"></i>
									<?php elseif($tab['button'] == 'genericons') : ?>
										<span class="genericon-wrap">
												<?php echo $this->_prepare_genericon($tab['icon']); ?>
											</span>
									<?php else: ?>
										<span class="svg-wrap">
												<?php echo $tab['icon'] ?>
											</span>
									<?php endif; ?>
								</div>
								<?php endif; ?>
							<?php endif; ?>
							<span class="label"><?php echo $tab['name'] ?></span>
						</button>
						<?php if ($tab['type'] == 'menu') :
							$tabNum = $index + 1; ?>
							<div class="tabbar-menu">
								<?php if ($this->settings['enable_search']) :?>
									<div class="search-bar">
										<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
											<input type="text" class="field" name="s" id="s" placeholder="Search..." />		
										</form>
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
	 * fix genericon svg xlink
	 * @param string
	 * @return string
	 */

	private function _prepare_genericon($icon){
		$url = 'href="'.get_template_directory_uri().'/dist/vendor/genericons/svg-sprite/';
		preg_match('/href="(.+)"/',$icon,$match);
		$url .= $match[1].'"';
		return preg_replace('/href="(.+)"/', $url, $icon);
	}
}

