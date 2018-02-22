<?php

namespace Tabbar;

class SettingsPage
{
	protected $slug = 'tabbar_settings';
	protected $assetsUrl;

	public function __construct($assetsUrl)
	{
		$this->assetsUrl = $assetsUrl;

		add_action('admin_menu', [$this, 'addOptionsPage']);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
	}

	public function addOptionsPage()
	{
		add_submenu_page(
			'hip_settings',
			'Tab Bar Settings',
			'Tab Bar',
			'manage_options',
			$this->slug,
			[$this, 'optionsPageContent']
		);
	}

	public function optionsPageContent()
	{

		?>
		<div class="hip-settings">
			<h1><?php _e('Tab Bar Settings', 'hip') ?></h1>
			<form id="tabbar-form">
				<h2><?php _e('Tabs', 'hip') ?></h2>
				<p class="description"><?php _e('The following settings are for each tab, from left to right.', 'hip') ?></p>
				<?php for ($i = 0; $i < 4; $i++) : ?>
					<h3><?php echo wp_sprintf('%s %s', __('Tab', 'hip'), $i + 1) ?></h3>
					<table class="form-table">
						<tbody>
						<tr>
							<th>
								<?php _e('Name', 'hip') ?>
							</th>
							<td><input id="tab<?php echo $i ?>_name" name="tab[<?php echo $i ?>][name]" type="text"
									   class="regular-text"/></td>
						</tr>
						<tr>
							<th>
								<?php _e('Button Style') ?>
							</th>
							<td>
								<select id="tab<?php echo $i ?>_button" name="tab[<?php echo $i ?>][button]">
									<option value="svg"><?php _e('SVG', 'hip') ?></option>
									<option value="hamburger"><?php _e('Hamburger', 'hip') ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th>
								<?php _e('SVG', 'hip') ?>
							</th>
							<td><textarea id="tab<?php echo $i ?>_svg" name="tab[<?php echo $i ?>][svg]"
										  style="width: 25em;"></textarea></td>
						</tr>
						<tr>
							<th>
								<?php _e('Type', 'hip') ?>
							</th>
							<td>
								<select id="tab<?php echo $i ?>_type" name="tab[<?php echo $i ?>][type]">
									<option value="link"><?php _e('Link', 'hip') ?></option>
									<option value="menu"><?php _e('Menu', 'hip') ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th>
								<?php _e('Link URL', 'hip') ?>
							</th>
							<td><input id="tab<?php echo $i ?>_link" name="tab[<?php echo $i ?>][link]" type="text"
									   class="regular-text"/></td>
						</tr>
						</tbody>
					</table>
					<br/>
					<hr/>
					<br/>
				<?php endfor; ?>
				<h2><?php _e('Styles', 'hip') ?></h2>
				<p class="description"><?php _e('The following settings apply globally', 'hip') ?></p>
				<table class="form-table">
					</tbody>
					<tr>
						<th><?php _e('Hide on windows larger than:', 'hip') ?></th>
						<td><input id="max_width" name="max_width" type="number"/> px</td>
					</tr>
					<tr>
						<th><?php _e('Background Color:', 'hip') ?></th>
						<td><input id="bg_color" class="hip-colorpicker" name="bg_color" type="text"/></td>
					</tr>
					<tr>
						<th><?php _e('Foreground Color:', 'hip') ?></th>
						<td><input id="fg_color" class="hip-colorpicker" name="fg_color" type="text"/></td>
					</tr>
					<tr>
						<th><?php _e('Selected Color:', 'hip') ?></th>
						<td>
							<input id="selected_color" class="hip-colorpicker" name="selected_color" type="text"/> <br/>
							<span class="description"><?php _e('Used for hover effects and opened submenus.', 'hip') ?></span>
						</td>
					</tr>
					</tbody>
				</table>
				<hr/>
				<br/>
				<table class="form-table">
					<h2><?php _e('Search bar', 'hip') ?></h2>
					</tbody>
					<tr>
						<th><?php _e('Enable search bar', 'hip') ?></th>
						<td><input id="enable_search" name="enable_search" type="checkbox" /> <label for="enable_search">Enable</label></td>
					</tr>
					<tr>
						<th><?php _e('Background Color:', 'hip') ?></th>
						<td>
							<input id="search_bg" class="hip-colorpicker" name="search_bg" type="text"/>
							<p class="description"><small>Default value is 20% darker then background color</small></p>
						</td>
					</tr>
					<tr>
						<th><?php _e('Button Color:', 'hip') ?></th>
						<td>
							<input id="search_btn_color" class="hip-colorpicker" name="search_btn_color" type="text"/>
							<p class="description"><small>Default value is same as foreground color</small></p>
						</td>

					</tr>
					</tbody>
				</table>
				<button type="submit" class="button-primary">Submit</button>
				<span id="feedback"></span>
			</form>
		</div>
		<?php
	}

	public function enqueueAssets()
	{
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
		wp_register_script($this->slug, $this->assetsUrl . 'js/tabbar-admin.js', ['jquery']);
		wp_localize_script($this->slug, 'tabbar', [
			'strings' => [
				'saved' => __('Settings Saved', 'hip'),
				'error' => __('Error', 'hip')
			],
			'api'     => [
				'url'   => esc_url_raw(rest_url('hip-api/v1/settings/tabbar')),
				'nonce' => wp_create_nonce('wp_rest')
			]
		]);
		wp_enqueue_script($this->slug);
	}
}
