<?php

namespace HipVideoCollection;

class SettingsPage
{

	/**
	 * slug for video collection settings page
	 * @var string
	 */

	protected $slug = 'video_collection_settings';

	/**
	 * theme assetsurl folder url
	 * @var string
	 */

	protected $assetsUrl;

	protected $settings;


	//  public $post_type;

	public function __construct($collection)
	{
		$this->assetsUrl = HVC_URL . '/assets/';
		add_action('admin_menu', [$this, 'addOptionsPage'], 5);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
		$this->post_type = $collection->post_type;
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
			'Video Collection',
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
		<script type='text/javascript'>
			jQuery(document).ready(function ($) {
				$('.color').wpColorPicker();
			});
		</script>

		<div class="video-settings">
			<h1><?php _e('Video Collection Settings', 'hip') ?></h1>
			<form id="hip-video-collection-form">

				<h3>Video Collection Archive Settings</h3>
				<table class="form-table">
					<tbody>
					<tr>
						<th>Archive Title</th>
						<td>
							<input id="video_archive_title" name="video_archive_title" type="text" class="regular-text"
								   value="<?php echo $this->settings['video_archive_title'] ?>">
						</td>
					</tr>
					<tr>
						<th>Archive URL Slug</th>
						<td>
							<input id="video_archive_slug" name="video_archive_slug" type="text" class="regular-text"
								   value="<?php echo $this->settings['video_archive_slug'] ?>">
						</td>
					</tr>
					<tr>
						<th>Youtube api key</th>
						<td>
							<input id="youtube_api_key" name="youtube_api_key" type="text" class="regular-text" placeholder="Your api key" value="<?php echo $this->settings['youtube_api_key'] ?>">
						</td>
					</tr>
					<tr>
						<th> Max width of the video embed</th>
						<td>
							<input id="embed_max_width" name="embed_max_width" type="number" placeholder="Default 900" value="<?php echo !empty($this->settings['embed_max_width']) ? $this->settings['embed_max_width'] : '' ?>"> px
						</td>
					</tr>
					</tbody>
				</table>

				<table class="form-table">
					<tr>
						<th><label for="video_play_btn_color">Play button color</label></th>
						<td><input type="text" id="video_play_btn_color" class="regular-text color" value="<?php echo !empty($this->settings['video_play_btn_color']) ? $this->settings['video_play_btn_color'] : ''; ?>" name="video_play_btn_color"></td>
					</tr>
					<tr>
						<th><label for="video_play_btn_hover_color">Play button color (on hover)</label></th>
						<td><input type="text" id="video_play_btn_hover_color" class="regular-text color" value="<?php echo !empty($this->settings['video_play_btn_hover_color']) ? $this->settings['video_play_btn_hover_color'] : ''; ?>" name="video_play_btn_hover_color"></td>
					</tr>
					<tr>
						<th><label for="video_play_btn_bg_color">Play button background color</label></th>
						<td><input type="text" id="video_play_btn_bg_color" class="regular-text color" value="<?php echo !empty($this->settings['video_play_btn_bg_color']) ? $this->settings['video_play_btn_bg_color'] : ''; ?>" name="video_play_btn_bg_color"></td>
					</tr>
					<tr>
						<th><label for="video_play_btn_hover_bg_color">Play button background color (on hover)</label>
						</th>
						<td><input type="text" id="video_play_btn_hover_bg_color" class="regular-text color" value="<?php echo !empty($this->settings['video_play_btn_hover_bg_color']) ? $this->settings['video_play_btn_hover_bg_color'] : ''; ?>" name="video_play_btn_hover_bg_color"></td>
					</tr>
					<tr>
						<th>Pulse Animation Effect btn:</th>
						<td>
							<input type="checkbox" id="play_defalut_style" name="play_defalut_style"/>
							<label for="play_defalut_style"><?php _e('Enabled', 'hip') ?></label>
						</td>
					</tr>
				</table>
				<button type="submit" class="button-primary">Submit</button>
				<span id="feedback"></span>
			</form>
		</div>

		<!--wp admin video collection settings message -->
		<style type="text/css">
			.video-settings #feedback {
				display: block;
				position: fixed;
				top: 50px;
				width: 100%;
				max-width: 50%;
				margin: 0 auto;
				left: 0;
				right: 0
			}

			.video-settings #feedback p {
				font-size: 1.3em;
				display: block;
				text-align: center;
				letter-spacing: 1px;
				padding: .75rem 1.25rem;
				margin-bottom: 1rem;
				border: 1px solid transparent;
				border-radius: .25rem
			}

			.video-settings #feedback p.success {
				color: #155724;
				background-color: #d4edda;
				border-color: #c3e6cb
			}

			.video-settings #feedback p.failure {
				color: #721c24;
				background-color: #f8d7da;
				border-color: #f5c6cb
			}
		</style>

		<?php
	}

	/**
	 * add assets for admin
	 * localize variable for use in video-collection js
	 * @return void
	 */

	public function enqueueAssets()
	{
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');

		wp_enqueue_script($this->slug . '-scripts', $this->assetsUrl . 'video-collection-settings.js', ['jquery']);
		wp_localize_script($this->slug . '-scripts', 'video_collection', [
			'strings' => [
				'saved' => __('Settings Saved successfully!!', 'hip'),
				'error' => __('An error encountered. Try again.', 'hip')
			],
			'api'     => [
				'url'   => esc_url_raw(rest_url('hip-api/v1/settings/video-collection')),
				'nonce' => wp_create_nonce('wp_rest')
			],

		]);

		wp_enqueue_script($this->slug);
	}
}// End SettingsPage Class for video-collection
