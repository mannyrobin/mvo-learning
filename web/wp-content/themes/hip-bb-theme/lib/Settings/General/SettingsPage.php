<?php

namespace Hip\Theme\Settings\General;

class SettingsPage
{
	/**
	 * slug for settings page
	 * @var string
	 */
	protected $slug = 'hip_settings';
	/**
	 * theme assets folder url
	 * @var string
	 */
	protected $assetsUrl;
	/**
	 * @var GoogleFontsHandler
	 */
	protected $font_handler;
	/**
	 * saved general settings
	 * @var array
	 */
	private $saved_settings;

	public function __construct($assetsUrl, $font_handler)
	{
		$this->assetsUrl = $assetsUrl;
		$this->font_handler = $font_handler;
		$this->saved_settings = \Hip\Theme\Settings\General\Settings::getSettings();
		add_action('admin_menu', [$this, 'addOptionsPage'], 5);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
	}

	/**
	 * add options page in admin dashboard
	 * @return void
	 */

	public function addOptionsPage()
	{
			add_menu_page(
				'Hip Settings',
				'Hip Settings',
				'manage_options',
				'hip_settings',
				[ $this, 'optionsPageContent' ],
				'dashicons-admin-site'
			);
	}

	/**
	 * add options page content
	 * @return void
	 */

	public function optionsPageContent()
	{
		$google_fonts = $this->font_handler->getFontList();

		?>
		<div class="hip-settings">
			<h1><?php _e('General Settings', 'hip') ?></h1>
			<form id="hip-settings-form">
				<h2><?php _e('Logo', 'hip') ?></h2>
				<p class="description"><?php _e('Upload site logo here.', 'hip') ?></p>
				<table class="form-table">
					<tbody>
					<tr>
						<th>
							<?php _e('Logo Style') ?>
						</th>
						<td>
							<select id="logo_type" name="logo_type" class="logo_type">
								<option value="svg"><?php _e('SVG', 'hip') ?></option>
								<option value="img"><?php _e('Image', 'hip') ?></option>
							</select>
						</td>
					</tr>
					<tr class="svg_logo">
						<th><?php _e('Svg code', 'hip') ?></th>
						<td><textarea id="svg_logo" name="svg_logo" style="width: 25em;"></textarea></td>
					</tr>
					<tr class="img_logo">
						<th><?php _e('Logo image', 'hip') ?></th>
						<td>
							<img src="." alt="" class="site_logo logo">
							<button type="button" name="upload_logo" class="upload_logo button"><?php echo !empty($this->saved_settings['logo_img']) ? 'Change' : 'Upload' ?> logo</button>
							<input type="hidden" value="" name="logo_img" id="logo_img">
						</td>
					</tr>
					<tr>
						<th>
							<?php _e('Alternative Logo Style') ?>
						</th>
						<td>
							<select id="alt_logo_type" name="alt_logo_type" class="alt_logo_type">
								<option value="alt_svg"><?php _e('SVG', 'hip') ?></option>
								<option value="alt_img"><?php _e('Image', 'hip') ?></option>
							</select>
						</td>
					</tr>
					<tr class="alt_svg_logo">
						<th><?php _e('Svg code', 'hip') ?></th>
						<td><textarea id="alt_svg_logo" name="alt_svg_logo" style="width: 25em;"></textarea></td>
					</tr>
					<tr class="alt_img_logo">
						<th><?php _e('Logo image', 'hip') ?></th>
						<td>
							<img src="." alt="" class="site_logo alt_logo">
							<button type="button" name="upload_logo"  class="button upload_logo"><?php echo !empty($this->saved_settings['alt_logo_img']) ? 'Change' : 'Upload' ?> logo</button>
							<input type="hidden" value="" name="alt_logo_img" id="alt_logo_img">
						</td>
					</tr>
					</tbody>
				</table>
				<hr/>
				<br/>
				<h2><?php _e('Fonts', 'hip') ?></h2>
				<p class="description"><?php _e('The following font settings will be applied globally', 'hip') ?></p>
				<table class="form-table">
					<tbody>
					<tr class="font-select">
						<th><?php _e('Body font', 'hip') ?></th>

						<td class="inline-field">
							<select name="body_font" id="body_font" class="google-font">
								<?php foreach ($google_fonts as $google_font) : ?>
									<option value="<?php echo $google_font['family']; ?>"><?php echo $google_font['family']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td class="inline-field">
							<h4><?php _e('Weight:', 'hip') ?></h4>
							<select name="body_font_weight" id="body_font_weight">
								<?php
								foreach (reset($google_fonts)['weights'] as $weight) : ?>
									<option value="<?php echo $this->font_handler->getWeightValFromLabel($weight); ?>"><?php echo $weight ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td class="inline-field">
							<h4><?php _e('Size:', 'hip') ?></h4>
							<input name="body_font_size" id="body_font_size" type="text"
							/>
							<p class="description small">With unit(eg. px, em or rem)</p>
						</td>
						<td></td>
					</tr>
					<tr class="font-select">
						<th><?php _e('Header', 'hip') ?></th>

						<td class="inline-field">
							<select name="header_font" id="header_font" class="google-font">
								<?php foreach ($google_fonts as $google_font) : ?>
									<option value="<?php echo $google_font['family']; ?>"><?php echo $google_font['family']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td class="inline-field">
							<h4><?php _e('Weight:', 'hip') ?></h4>
							<select name="header_font_weight" id="header_font_weight">
								<?php foreach (reset($google_fonts)['weights'] as $weight) : ?>
									<option value="<?php echo $this->font_handler->getWeightValFromLabel($weight); ?>"><?php echo $weight ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td></td>
					</tr>
					</tbody>
				</table>
				<hr/>
				<br/>
				<h2><?php _e('Colors', 'hip') ?></h2>
				<p class="description"><?php _e('The following color settings will be applied globally', 'hip') ?></p>
				<table class="form-table">
					<tbody>
					<tr>
						<th><?php _e('Primary color', 'hip') ?></th>
						<td>
							<input name="primary_color" id="primary_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Primary highlight color', 'hip') ?></th>
						<td>
							<input name="primary_highlight_color" id="primary_highlight_color" class="hip-colorpicker"  type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Secondary color', 'hip') ?></th>
						<td>
							<input name="secondary_color" id="secondary_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Secondary highlight color', 'hip') ?></th>
						<td>
							<input name="secondary_highlight_color" id="secondary_highlight_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th>
							<?php _e('Tertiary color', 'hip') ?>
							<p class="help-text">Will be used as background color.</p>
						</th>

						<td>
							<input name="tertiary_color" id="tertiary_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th>
							<?php _e('Tertiary light color', 'hip') ?>
							<p class="help-text">Will be used as light background color.</p>
						</th>
						<td>
							<input name="tertiary_light_color" id="tertiary_light_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Body font color', 'hip') ?></th>
						<td>
							<input name="body_font_color" id="body_font_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Link color', 'hip') ?></th>
						<td>
							<input name="link_color" id="link_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Link hover color', 'hip') ?></th>
						<td>
							<input name="link_hover_color" id="link_hover_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Menu item hover background/border', 'hip') ?>
							<p class="help-text">Will be used as hover background in header style 1 and 2, bottom border for header style 3.</p>
						</th>
						<td>
							<input name="menu_item_hover_color" id="menu_item_hover_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Sub-menu font color', 'hip') ?></th>
						<td>
							<input name="sub_menu_font_color" id="sub_menu_font_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Sub-menu font hover color', 'hip') ?></th>
						<td>
							<input name="sub_menu_font_hover_color" id="sub_menu_font_hover_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Sub-menu background color', 'hip') ?></th>
						<td>
							<input name="sub_menu_bg_color" id="sub_menu_bg_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Sub-menu background hover color', 'hip') ?></th>
						<td>
							<input name="sub_menu_bg_hover_color" id="sub_menu_bg_hover_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					</tbody>
				</table>
                <hr/>
                <br/>
                <h2><?php _e('Button', 'hip') ?></h2>
                <p class="description"><?php _e('The following settings will be applied to all buttons and modules that have css class general-btn', 'hip') ?></p>
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th><?php _e('Button text color', 'hip') ?></th>
                        <td>
                            <input name="btn_color" id="btn_color" class="hip-colorpicker" type="text"/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Button text hover color', 'hip') ?></th>
                        <td>
                            <input name="btn_hover_color" id="btn_hover_color" class="hip-colorpicker" type="text"/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Button background color', 'hip') ?></th>
                        <td>
                            <input name="btn_bg_color" id="btn_bg_color" class="hip-colorpicker" type="text"/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Button background hover color', 'hip') ?></th>
                        <td>
                            <input name="btn_bg_hover_color" id="btn_bg_hover_color" class="hip-colorpicker" type="text"/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Border style', 'hip') ?></th>
                        <td>
                            <select name="btn_border" id="btn_border">
                                <option value="none">None</option>
                                <option value="all">All side</option>
                                <option value="btm">Bottom</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Border width', 'hip') ?></th>
                        <td>
                            <input name="btn_border_width" id="btn_border_width" type="number"/> px
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Border color', 'hip') ?></th>
                        <td>
                            <input name="btn_border_color" id="btn_border_color" class="hip-colorpicker" type="text"/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Border hover color', 'hip') ?></th>
                        <td>
                            <input name="btn_border_hover_color" id="btn_border_hover_color" class="hip-colorpicker" type="text"/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Rounded corner', 'hip') ?></th>
                        <td>
                            <input name="btn_radius" id="btn_radius" type="number"/> px
                        </td>
                    </tr>
                    </tbody>
                </table>
				<br/>
				<h2><?php _e('Breadcrumb', 'hip') ?></h2>
				<p class="description"><?php _e('The following settings will be applied globally', 'hip') ?></p>
				<table class="form-table">
					<tbody>
					<tr>
						<th><?php _e('Text color', 'hip') ?></th>
						<td>
							<input name="b_text_color" id="b_text_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Text hover color', 'hip') ?></th>
						<td>
							<input name="b_text_hover_color" id="b_text_hover_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Current page text color', 'hip') ?></th>
						<td>
							<input name="b_current_text_color" id="b_current_text_color" class="hip-colorpicker"  type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Separator color', 'hip') ?></th>
						<td>
							<input name="b_sep_color" id="b_sep_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr>
						<th><?php _e('Background color', 'hip') ?></th>
						<td>
							<input name="b_bg_color" id="b_bg_color" class="hip-colorpicker" type="text"/>
						</td>
					</tr>
					<tr class="decision-check">
						<th><?php _e('Enable left border', 'hip') ?></th>
						<td>
							<input type="checkbox" id="enable_border" name="enable_border"/><label for="enable_border"><?php _e('Yes', 'hip') ?></label>
						</td>
					</tr>
					<tr class="decision-content">
						<td colspan="2">
							<table>
								<tr>
									<th><?php _e('Left border Size', 'hip') ?></th>
									<td>
										<input name="b_border_size" id="b_border_size" type="number" min="0"/> px
									</td>
								</tr>
								<tr>
									<th><?php _e('Left border color', 'hip') ?></th>
									<td>
										<input name="b_border_color" id="b_border_color" class="hip-colorpicker" type="text"/>
									</td>
								</tr>
							</table>
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

	/**
	 * add assets for admin
	 * localize variable for use in js
	 * @return void
	 */

	public function enqueueAssets()
	{
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style($this->slug . '-styles', $this->assetsUrl . 'css/hip-settings.css');
		wp_enqueue_media();
		wp_localize_script('parent-js', 'hipSettings', array(
			'strings' => [
				'saved' => __('Settings Saved successfully!!', 'hip'),
				'error' => __('An error encountered. Try again.', 'hip')
			],
			'api'     => [
				'url'   => esc_url_raw(rest_url('hip-api/v1/settings/general')),
				'nonce' => wp_create_nonce('wp_rest')
			],
			'google_fonts' => $this->font_handler->getFontList()
		));
	}
}
