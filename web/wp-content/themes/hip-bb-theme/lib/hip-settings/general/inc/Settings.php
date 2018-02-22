<?php

namespace General;

class Settings
{
	/**
	 * option key for saving options
	 * @var string
	 */
	protected static $optionKey = '_general_settings';

	/**
	 * set default options
	 * @var array
	 */
	protected static $defaults = [
		'logo_type' => 'svg',
		'body_font' => 'Open Sans',
		'body_font_weight' => '400',
		'body_font_size' => '16px',
		'body_font_color' => '#444',
		'header_font' => 'Lato',
		'header_font_weight' => '700',
		'link_color' => '#0066ff',
		'link_hover_color' => '#0033cc'
	];

	/**
	 * get settings from db
	 * @return array
	 */

	public static function getSettings()
	{
		$saved = get_option(self::$optionKey, []);

		if (!is_array($saved) || empty($saved)) {
			return self::$defaults;
		}
		return $saved;
	}

	/**
	 * save settings in db
	 * @param array
	 */
	public static function saveSettings(array $settings)
	{
		$option = [];

		foreach ($settings as $key => $value) {
			if (!empty($value)) {
				if ($key == 'logo_img' || $key == 'alt_logo_img') {
					$option[$key] = esc_url_raw($value);
					continue;
				}
				if ($key == 'svg_logo' || $key == 'alt_svg_logo') {
					$option[$key] = $value;
					continue;
				}
				$option[$key] = sanitize_text_field($value);
			}
		}
		update_option(self::$optionKey, $option);
	}
}
