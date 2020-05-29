<?php

namespace Hip\Theme\Settings\BusinessInfo;

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

	protected $available_specialties = [
		'Anesthesia',
		'Cardiovascular',
		'CommunityHealth',
		'Dentistry',
		'Dermatologic',
		'Dermatology',
		'DietNutrition',
		'Emergency',
		'Endocrine',
		'Gastroenterologic',
		'Genetic',
		'Geriatric',
		'Gynecologic',
		'Hermatologic',
		'Infectious',
		'LaboratoryScience',
		'Midwifery',
		'Musculoskeletal',
		'Neurologic',
		'Nursing',
		'Obstetric',
		'Otolaryngologic',
		'Pathology',
		'Pediatric',
		'PharmacySpecialty',
		'Physiotherapy',
		'PlasticSurgery',
		'Podiatric',
		'PrimaryCare',
		'Psychiatric',
		'PublicHealth',
		'Pulmonary',
		'Radiography',
		'Renal',
		'RespiratoryTherapy',
		'Rheumatologic',
		'SpeechPathology',
		'Surgical',
		'Toxicologic',
		'Urologic'
	];

	public function __construct($assetsUrl)
	{
		$this->assetsUrl = $assetsUrl;
		$this->business_saved_settings = \Hip\Theme\Settings\BusinessInfo\Settings::getSettings();
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
						<th>Medical Practice</th>
						<td>
							<p><label for="businessinfo_specialty">Medical Specialty</label></p>
							<?php $selected = !empty($this->business_saved_settings['businessinfo_specialty']) ? $this->business_saved_settings['businessinfo_specialty'] : ''; ?>
							<select id="businessinfo_specialty" name="businessinfo_specialty">
								<option value="" <?php if ( empty($selected) ) echo ' selected'; ?>>None/Not Applicable</option>
								<?php foreach ( $this->available_specialties as $specialty ) {
									$select = ( $selected == $specialty ) ? ' selected' : '';
									echo "<option value='$specialty' $select>$specialty</option>";
								}?>
							</select>
						</td>
					</tr>
					<tr>
						<th colspan="3">Socials Media Icons &nbsp;<button type="button" class="button-primary add-field">Add</button></th>
					</tr>
					<tr data-index="0" class="repeatable-field">
						<td>
							<p><label for="social_media[0][icon]">Icon Class</label></p>
							<input type="text" list="icons" id="social_media[0][icon]" class="regular-text" name="social_media[0][icon]">
						</td>
						<td>
							<p><label for="social_media[0][link]">Icon Link</label></p>
							<input type="text" id="social_media[0][link]" class="regular-text" name="social_media[0][link]">
						</td>
						<td>
							<button type="button" class="button-primary add-field">Add</button>
							<button type="button" class="button-secondary remove-field">Remove</button>
						</td>
					</tr>
					<tr>
						<td>
							<datalist id="icons">
								<option value="fab fa-facebook">
								<option value="fab fa-facebook-f">
								<option value="fab fa-facebook-square">
								<option value="fab fa-twitter">
								<option value="fab fa-twitter-square">
								<option value="fab fa-google">
								<option value="fab fa-google-plus-g">
								<option value="fab fa-google-plus">
								<option value="fab fa-google-plus-square">
								<option value="fab fa-linkedin">
								<option value="fab fa-linkedin-in">
								<option value="fab fa-instagram">
								<option value="fab fa-youtube">
								<option value="fab fa-youtube-square">
								<option value="fab fa-pinterest">
								<option value="fab fa-pinterest-p">
								<option value="fab fa-pinterest-square">
								<option value="fab fa-yalp">
								<option value="fab fa-vimeo">
								<option value="fab fa-vimeo-v">
								<option value="fab fa-vimeo-square">
								<option value="fab fa-dribbble">
								<option value="fab fa-dribbble-square">
							</datalist>
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
							<input type="checkbox" id="social_brand_styles" name="social_brand_styles"/><label for="social_brand_styles"><?php _e('Use Brand Styles', 'hip') ?></label>
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
		wp_localize_script('parent-js', 'business_info', [
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
