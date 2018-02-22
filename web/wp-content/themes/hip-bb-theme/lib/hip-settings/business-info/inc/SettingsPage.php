<?php

namespace BusinessInfo;

class SettingsPage
{
	/**
	 * slug for business info settings page
	 * @var string
	 */

	protected $slug = 'businessinfo_settings';

	/**
	 * theme assets folder url
	 * @var string
	 */

	protected $assetsUrl;

	/**
	 * saved business info settings
	 * @var array
	 */

	private $business_saved_settings;

	public function __construct($assetsUrl)
	{
		$this->assetsUrl = $assetsUrl;
		$this->business_saved_settings = \BusinessInfo\Settings::getSettings();
		add_action('admin_menu', [$this, 'addOptionsPage'], 5);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
	}

	/**
	 * add options page in admin dashboard
	 * submenu hip setting
	 * @return void
	 */

	public function addOptionsPage()
	{
		add_submenu_page(
			'hip_settings',
			'Business Info',
			'Business Info',
			'manage_options',
			$this->slug,
			[$this, 'optionsPageContent']
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
			<h1><?php _e('Business Settings', 'hip') ?></h1>
			<form id="hip-businessinfo-form">
				<table class="form-table" style="max-width: 1020px">
					<tr>
						<th><label for="businessinfo_phone_number">Phone Number</label></th>
						<td><input type="text" id="businessinfo_phone_number" class="regular-text" name="businessinfo_phone_number"></td>
						<td><span class="validation-txt"></span></td>
					</tr>
					<tr>
						<th><label for="businessinfo_address">Business Info Address</label></th>
						<td><textarea id="businessinfo_address" class="bus_info_textarea" name="businessinfo_address" rows="7" cols="53"></textarea></td>
					</tr>
					<tr>
						<th>Socials Media</th>
						<td>
							<p><label for="businessinfo_facebook_icon">Facebook Icon Class</label></p>
							<input type="text" id="businessinfo_facebook_icon" class="regular-text" name="businessinfo_facebook_icon">
						</td>
						<td>
							<p><label for="businessinfo_facebook_link">Facebook Link</label></p>
							<input type="text" id="businessinfo_facebook_link" class="regular-text" name="businessinfo_facebook_link">
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<p><label for="businessinfo_twitter_icon">Twitter Icon Class</label></p>
							<input type="text" id="businessinfo_twitter_icon" class="regular-text" name="businessinfo_twitter_icon">
						</td>
						<td>
							<p><label for="businessinfo_twitter_link">Twitter Link</label></p>
							<input type="text" id="businessinfo_twitter_link" class="regular-text" name="businessinfo_twitter_link">
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<p><label for="businessinfo_instagram_icon">Instagram Icon Class</label></p>
							<input type="text" id="businessinfo_instagram_icon" class="regular-text" name="businessinfo_instagram_icon">
						</td>
						<td>
							<p><label for="businessinfo_instagram_link">Instagram Link</label></p>
							<input type="text" id="businessinfo_instagram_link" class="regular-text" name="businessinfo_instagram_link">
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<p><label for="businessinfo_linkedin_icon">linkedin Icon Class</label></p>
							<input type="text" id="businessinfo_linkedin_icon" class="regular-text" name="businessinfo_linkedin_icon">
						</td>
						<td>
							<p><label for="businessinfo_linkedin_link">linkedin Link</label></p>
							<input type="text" id="businessinfo_linkedin_link" class="regular-text" name="businessinfo_linkedin_link">
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<p><label for="businessinfo_google_icon">Google+ Icon Class</label></p>
							<input type="text" id="businessinfo_google_icon" class="regular-text" name="businessinfo_google_icon">
						</td>
						<td>
							<p><label for="businessinfo_google_link">Google+ Link</label></p>
							<input type="text" id="businessinfo_google_link" class="regular-text" name="businessinfo_google_link">
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<p><label for="businessinfo_youtube_icon">Youtube Icon Class</label></p>
							<input type="text" id="businessinfo_youtube_icon" class="regular-text" name="businessinfo_youtube_icon">
						</td>
						<td>
							<p><label for="businessinfo_youtube_link">Youtube Link</label></p>
							<input type="text" id="businessinfo_youtube_link" class="regular-text" name="businessinfo_youtube_link">
						</td>
					</tr>
                    <tr>
                        <th></th>
                        <td>
                            <p><label for="businessinfo_pinterest_icon">Pinterest Icon Class</label></p>
                            <input type="text" id="businessinfo_pinterest_icon" class="regular-text" name="businessinfo_pinterest_icon">
                        </td>
                        <td>
                            <p><label for="businessinfo_pinterest_link">Pinterest Link</label></p>
                            <input type="text" id="businessinfo_pinterest_link" class="regular-text" name="businessinfo_pinterest_link">
                        </td>
                    </tr>
				</table>

                <hr/>
                <br/>
                <h2><?php _e('Social Media Styles', 'hip') ?></h2>
                <p class="description"><?php _e('The following Social Media styles  will be applied globally', 'hip') ?></p>
                <table class="form-table" >
                    <tbody>
                    <tr>
                        <th><h4><label for="social_media_height"><?php _e('Height:', 'hip') ?></label></h4></th>
                        <td class="inline-field">
                            <input type="text" id="social_media_height" class="" name="social_media_height">
                            <p class="small">With unit(eg. px, em or rem)</p>
                        </td>
                    </tr>
                    <tr>
                        <th> <h4><label for="social_media_width"><?php _e('Width:', 'hip') ?></label></h4></th>
                        <td class="inline-field">
                            <input type="text" id="social_media_width" class="" name="social_media_width">
                            <p class="small">With unit(eg. px, em or rem)</p>

                        </td>
                    </tr>
                    <tr>
                        <th><h4><label for="icon_font_size"><?php _e('Icon Size:', 'hip') ?></label></h4></th>
                        <td class="inline-field">
                            <input type="text" id="icon_font_size" class="" name="icon_font_size">
                            <p class="small">With unit(px, em or rem)</p>
                        </td>
                    </tr>

                    <tr class="font-select" id="brand">
                        <th>Social Item Brand:</th>
                        <td>
                            <input type="checkbox" id="social_brand_styles" name="social_brand_styles"/><label for="social_brand_styles"><?php _e('Use Brand Styles:', 'hip') ?></label>
                        </td>
                    </tr>

                    <tr class="font-select" id="no-brand">
                        <th>Custom Styles:</th>
                        <td class="inline-field">
                            <label for="social_icon_color"><?php _e('Icon Color:', 'hip') ?></label><br>
                            <input type="text" id="social_icon_color" class="hip-colorpicker" name="social_icon_color">
                        </td>
                        <td class="inline-field">
                            <label for="social_icon_hover_color"><?php _e('Icon Hover Color:', 'hip') ?></label><br>
                            <input type="text" id="social_icon_hover_color" class="hip-colorpicker" name="social_icon_hover_color">
                        </td>
                        <td class="inline-field">
                            <label for="social_icon_bg"><?php _e('Icond Background:', 'hip') ?></label><br>
                            <input type="text" id="social_icon_bg" class="hip-colorpicker" name="social_icon_bg">

                        </td>
                        <td class="inline-field">
                            <label for="social_icon_hover_bg"><?php _e('Icon Hover Background:', 'hip') ?></label><br>
                            <input type="text" id="social_icon_hover_bg" class="hip-colorpicker" name="social_icon_hover_bg">
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
	 * localize variable for use in businessinfo js
	 * @return void
	 */

	public function enqueueAssets()
	{
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script($this->slug . '-scripts', $this->assetsUrl . 'js/business-info.js', ['jquery']);
		wp_localize_script($this->slug . '-scripts', 'business_info', [
			'strings' => [
				'saved' => __('Settings Saved successfully!!', 'hip'),
				'error' => __('An error encountered. Try again.', 'hip')
			],
			'api'     => [
				'url'   => esc_url_raw(rest_url('hip-api/v1/settings/business-info')),
				'nonce' => wp_create_nonce('wp_rest')
			],
			
		]);

		wp_enqueue_script($this->slug);
	}
}// End SettingsPage Class for businessinfo
