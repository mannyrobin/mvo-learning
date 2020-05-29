<?php 

namespace Hip\LP;

class SettingsPage
{
	protected $slug = 'hip_lp_settings';

	public function addOptionsPage()
	{
		add_submenu_page(
			'hip_settings',
			'Landing Page Settings',
			'Landing Pages',
			'manage_options',
			$this->slug,
			[ $this, 'optionsPageContent' ]
		);
	}
	
	public function optionsPageContent()
	{
		?>
		<h1>Landing Pages Settings</h1>
		<form id="lp-settings-form">
			<h2>Custom Post Type Settings</h2>
			<table class="cpt-table">
				<tbody>
					<tr>
						<th>Label</th>
						<td>
							<input id="lp_label" name="lp_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>URL Slug</th>
						<td>
							<input id="lp_slug" name="lp_slug" type="text" class="regular-text"/>
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
							<input id="lp_cat_label" name="lp_cat_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>URL Slug</th>
						<td>
							<input id="lp_cat_slug" name="lp_cat_slug" type="text" class="regular-text"/>
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
		global $hipLP;
        if(strpos(get_current_screen()->id,$this->slug)){
            wp_register_script($this->slug, $hipLP['url'] . '/js/admin.js', ['jquery']);
            wp_localize_script($this->slug, 'hiplp', [
                'strings' => [
                    'saved' => __('Settings Saved', 'hip'),
                    'error' => __('Error', 'hip')
                ],
                'api'     => [
                    'url'   => esc_url_raw(rest_url('hip-api/v1/lp/settings')),
                    'nonce' => wp_create_nonce('wp_rest')
                ]
            ]);
            wp_enqueue_script($this->slug);
        }
	}
}