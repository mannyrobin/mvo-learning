<?php

namespace Hip\Services;

class SettingsPage
{
	protected $slug = 'hip_services_settings';
	public function addOptionsPage()
	{
		if (class_exists('HipSettings')) {
			add_submenu_page(
				'hip_settings',
				'Services Settings',
				'Services',
				'manage_options',
				$this->slug,
				[ $this, 'optionsPageContent' ]
			);
		} else {
			add_options_page(
				'Services Settings',
				'Services Settings',
				'manage_options',
				$this->slug,
				[ $this, 'optionsPageContent' ]
			);
		}
	}
	public function optionsPageContent()
	{
		?>
		<div class="hip-service-settings">
			<h1>Services Settings</h1>
			<form id="services-settings-form">
				<h2>Custom Post Type Settings</h2>
				<table class="cpt-table">
					<tbody>
					<tr>
						<th>Singular Label</th>
						<td>
							<input id="service_singular_label" name="service_singular_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>Plural Label</th>
						<td>
							<input id="service_plural_label" name="service_plural_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>URL Slug</th>
						<td>
							<input id="service_slug" name="service_slug" type="text" class="regular-text"/>
						</td>
					</tr>
					</tbody>
				</table>
				<h2>Custom Taxonomy Settings</h2>
				<table class="taxonomy-table">
					<tbody>
					<tr>
						<th>Label</th>
						<td>
							<input id="service_cat_label" name="service_cat_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>URL Slug</th>
						<td>
							<input id="service_cat_slug" name="service_cat_slug" type="text" class="regular-text"/>
						</td>
					</tr>
					</tbody>
				</table>
				<br/>
				<button type="submit" class="button-primary">Submit</button>
				<span id="feedback"></span>
			</form>
		</div>
		<?php
	}
	public function enqueueAssets()
	{
		global $hipServices;
		if (strpos(get_current_screen()->id, $this->slug) != false) {
			wp_register_style($this->slug, $hipServices['url'] . '/css/admin.css');
			wp_register_script($this->slug, $hipServices['url'] . '/js/admin.js', ['jquery']);
			wp_localize_script($this->slug, 'hipservices', [
				'strings' => [
					'saved' => __('Settings Saved', 'hip'),
					'error' => __('Error', 'hip')
				],
				'api'     => [
					'url'   => esc_url_raw(rest_url('hip-api/v1/services/settings')),
					'nonce' => wp_create_nonce('wp_rest')
				]
			]);
			wp_enqueue_script($this->slug);
			wp_enqueue_style($this->slug);
		}
	}
}
