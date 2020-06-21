<?php 

namespace HipStaff;

class SettingsPage
{
	protected $slug = 'hip_staff_settings';

	public function addOptionsPage()
	{
		if (class_exists('Hip\Theme\Settings')) {
			add_submenu_page(
				'hip_settings',
				'Staff Settings',
				'Staff',
				'manage_options',
				$this->slug,
				[ $this, 'optionsPageContent' ]
			);
		} else {
			add_submenu_page(
				'edit.php?post_type=staff',
				'Staff Settings',
				'Staff Settings',
				'manage_options',
				$this->slug,
				[ $this, 'optionsPageContent' ]
			);
		}
	}
	
	public function optionsPageContent()
	{
		?>
		<h1>Staff Settings</h1>
		<form id="staff-settings-form">
			<h2>Custom Post Type Settings</h2>
			<table class="cpt-table">
				<tbody>
					<tr>
						<th>Singular Label</th>
						<td>
							<input id="staff_singular_label" name="staff_singular_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>Plural Label</th>
						<td>
							<input id="staff_plural_label" name="staff_plural_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>URL Slug</th>
						<td>
							<input id="staff_slug" name="staff_slug" type="text" class="regular-text"/>
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
							<input id="staff_cat_label" name="staff_cat_label" type="text" class="regular-text"/>
						</td>
					</tr>
					<tr>
						<th>URL Slug</th>
						<td>
							<input id="staff_cat_slug" name="staff_cat_slug" type="text" class="regular-text"/>
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
		global $hipStaff;
		
		if(strpos(get_current_screen()->id,$this->slug)){
            wp_register_script($this->slug, $hipStaff['url'] . '/js/admin.js', ['jquery']);
            wp_localize_script($this->slug, 'hipstaff', [
                'strings' => [
                    'saved' => __('Settings Saved', 'hip'),
                    'error' => __('Error', 'hip')
                ],
                'api'     => [
                    'url'   => esc_url_raw(rest_url('hip-api/v1/staff/settings')),
                    'nonce' => wp_create_nonce('wp_rest')
                ]
            ]);
            wp_enqueue_script($this->slug);
        }
	}
}
