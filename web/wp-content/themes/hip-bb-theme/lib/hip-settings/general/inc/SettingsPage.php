<?php

namespace General;

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
	 * all google fonts
	 * @var array
	 */
	public $google_fonts;
	/**
	 * api key for getting google fonts from webfont api
	 * @var string
	 */
	private $api_key = 'AIzaSyCvZ6z9AoXrw4wbdnpgir_KZ9f06tJ4uKo';
	/**
	 * saved general settings
	 * @var array
	 */
	private $saved_settings;

	public function __construct($assetsUrl)
	{
		$this->assetsUrl = $assetsUrl;
		$this->google_fonts = $this->get_google_fonts($this->api_key);
		$this->saved_settings = \General\Settings::getSettings();
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
								<?php foreach ($this->google_fonts as $google_font) : ?>
									<option value="<?php echo $google_font['family']; ?>"><?php echo $google_font['family']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td class="inline-field">
							<h4><?php _e('Weight:', 'hip') ?></h4>
							<select name="body_font_weight" id="body_font_weight">
								<?php
								foreach (reset($this->google_fonts)['weights'] as $weight) : ?>
									<option value="<?php echo $this->_format_font_weight($weight); ?>"><?php echo $weight ?></option>
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
								<?php foreach ($this->google_fonts as $google_font) : ?>
									<option value="<?php echo $google_font['family']; ?>"><?php echo $google_font['family']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td class="inline-field">
							<h4><?php _e('Weight:', 'hip') ?></h4>
							<select name="header_font_weight" id="header_font_weight">
								<?php foreach (reset($this->google_fonts)['weights'] as $weight) : ?>
									<option value="<?php echo $this->_format_font_weight($weight); ?>"><?php echo $weight ?></option>
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
		wp_enqueue_script($this->slug . '-scripts', $this->assetsUrl . 'js/hip-settings.js', ['jquery']);
		wp_localize_script($this->slug . '-scripts', 'hipSettings', array(
			'strings' => [
				'saved' => __('Settings Saved successfully!!', 'hip'),
				'error' => __('An error encountered. Try again.', 'hip')
			],
			'api'     => [
				'url'   => esc_url_raw(rest_url('hip-api/v1/settings/general')),
				'nonce' => wp_create_nonce('wp_rest')
			],
			'google_fonts' => $this->google_fonts
		));
	}

	//======= Helper methods ======\\

	/**
	 * Get google fonts from google webfont api
	 * @param string
	 * @return mixed
	 */

	protected function get_google_fonts($api_key)
	{
		/*get google fonts*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/webfonts/v1/webfonts?key=' .$api_key);
		if (defined('WP_ENV')) {
			if (WP_ENV == 'development') {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			}
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		$output = curl_exec($ch);
		if ($output === false) {
			return 'curl_error ' . curl_error($ch);
		}
		curl_close($ch);

		/* make google fonts ready for use */

		$fonts_arr = json_decode($output);
		$google_fonts = array();
		foreach ($fonts_arr->items as $key => $font) {
			$google_fonts[$font->family] = array();
			$google_fonts[$font->family]['family'] = $font->family;
			$google_fonts[$font->family]['weights'] = array();
			foreach ($font->variants as $weight) {
				if ($weight == 'italic') {
					array_push($google_fonts[$font->family]['weights'], 'Regular (italic)');
				} else {
					if (stripos($weight, 'italic')) {
						array_push($google_fonts[$font->family]['weights'], str_replace('italic', ' (italic)', $weight));
					} else {
						array_push($google_fonts[$font->family]['weights'], ucfirst($weight));
					}
				}
			}
		}
		return $google_fonts;
	}

	/**
	 * Format google fonts for options value
	 * @param string
	 * @return string
	 */

	private function _format_font_weight($weight)
	{
		$fw = strtolower($weight);
		if ($fw == 'regular') {
			return '400';
		} else if ($fw == 'regular (italic)') {
			return '400i';
		} else if (stripos($fw, '(italic)')) {
			return str_replace(' (italic)', 'i', $fw);
		} else {
			return $fw;
		}
	}
}
