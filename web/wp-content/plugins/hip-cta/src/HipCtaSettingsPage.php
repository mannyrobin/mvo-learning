<?php

namespace HipCTA;

class SettingsPage
{

	/**
	 * slug for settings page
	 * @var string
	 */

	protected $slug = 'hip_cta_settings';

	/**
	 * assetsurl folder url
	 * @var string
	 */

	protected $assetsUrl;

	protected $settings;


	public function __construct($args)
	{
		$this->assetsUrl = $args['plugin_url'] . '/assets/';
		add_action('admin_menu', [$this, 'addOptionsPage'], 5);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
		$this->post_type = $args['post_type'];
		$this->settings = Settings::getSettings();

	}

	/**
	 * add options page in admin dashboard
	 * submenu hip setting
	 * @return void
	 */

	public function addOptionsPage()
	{
		add_submenu_page(
			'edit.php?post_type=' . $this->post_type . '',
			'Hip CTA Settings',
			'Settings',
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

		<div class="cta-settings">
			<h1><?php _e('Hip CTA Settings', 'hip') ?></h1>
			<p class="description"><?php _e('This settings will applied globally', 'hip') ?></p>
			<form id="hip-cta-settings-form">
				<table class="form-table">
					<tr>
						<th>Hide cta on mobile:</th>
						<td>
							<input type="checkbox" id="hide_cta_on_mobile" name="hide_cta_on_mobile"/>
							<label for="hide_cta_on_mobile"><?php _e('Yes', 'hip') ?></label>
						</td>
					</tr>
					<tr>
						<th><label for="mobile_width">Hide cta on window smaller than:</label></th>
						<td>
							<input type="number" id="mobile_width" name="mobile_width"/>px
						</td>
					</tr>
				</table>

				<button type="submit" class="button-primary">Submit</button>
				<span id="feedback"></span>
			</form>
		</div>

		<!--wp admin settings message -->
		<style type="text/css">
			.cta-settings #feedback {
				display: block;
				position: fixed;
				top: 50px;
				width: 100%;
				max-width: 50%;
				margin: 0 auto;
				left: 0;
				right: 0
			}

			.cta-settings #feedback p {
				font-size: 1.3em;
				display: block;
				text-align: center;
				letter-spacing: 1px;
				padding: .75rem 1.25rem;
				margin-bottom: 1rem;
				border: 1px solid transparent;
				border-radius: .25rem
			}

			.cta-settings #feedback p.success {
				color: #155724;
				background-color: #d4edda;
				border-color: #c3e6cb
			}

			.cta-settings #feedback p.failure {
				color: #721c24;
				background-color: #f8d7da;
				border-color: #f5c6cb
			}
		</style>

		<?php
	}

	/**
	 * add assets for admin
	 * localize variable for use in hip-cta-settings js
	 * @return void
	 */

	public function enqueueAssets()
	{
		if(strpos(get_current_screen()->id,$this->slug)) {
			wp_enqueue_script($this->slug . '-scripts', $this->assetsUrl . '/js/hip-cta-settings.js', ['jquery']);
			wp_localize_script($this->slug . '-scripts', 'hipcta', [
				'strings' => [
					'saved' => __('Settings Saved successfully!!', 'hip'),
					'error' => __('An error encountered. Try again.', 'hip')
				],
				'api' => [
					'url' => esc_url_raw(rest_url('hip-api/v1/settings/hip-cta')),
					'nonce' => wp_create_nonce('wp_rest')
				],

			]);

			wp_enqueue_script($this->slug);
		}
	}
}// End SettingsPage Class for hip-cta
