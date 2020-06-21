<?php

namespace Hip\Conditions;

class SettingsPage
{
	protected $slug = 'hip_conditions_settings';

	public function addOptionsPage()
	{
		add_submenu_page(
			'hip_settings',
			'Conditions Settings',
			'Conditions',
			'manage_options',
			$this->slug,
			[ $this, 'optionsPageContent' ]
		);
	}
	
	public function optionsPageContent()
	{
		?>
		<h1>Conditions Settings</h1>
		<form id="conditions-settings-form">
			<h2>Custom Post Type Settings</h2>
			<table class="cpt-table">
				<tbody>
					<tr>
						<th>Singular Label</th>
						<td>
							<input id="condition_singular_label" name="condition_singular_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>Plural Label</th>
						<td>
							<input id="condition_plural_label" name="condition_plural_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>URL Slug</th>
						<td>
							<input id="condition_slug" name="condition_slug" type="text" class="regular-text"/>
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
							<input id="condition_cat_label" name="condition_cat_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>URL Slug</th>
						<td>
							<input id="condition_cat_slug" name="condition_cat_slug" type="text" class="regular-text"/>
						</td>
					</tr>
				</tbody>
			</table>
			<br/>
			<button type="submit" class="button-primary">Submit</button>
			<span id="feedback"></span>
		</form>
		<?php
	}

	public function enqueueAssets()
	{
		global $hipConditions;
		
		if (strpos(get_current_screen()->id, $this->slug)) {
			wp_register_script($this->slug, $hipConditions['url'] . '/js/admin.js', ['jquery']);
			wp_localize_script($this->slug, 'hipconditions', [
				'strings' => [
					'saved' => __('Settings Saved', 'hip'),
					'error' => __('Error', 'hip')
				],
				'api'     => [
					'url'   => esc_url_raw(rest_url('hip-api/v1/conditions/settings')),
					'nonce' => wp_create_nonce('wp_rest')
				]
			]);

			wp_enqueue_script($this->slug);
		}
	}
}
