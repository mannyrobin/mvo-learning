<?php

namespace HipCTA;

class Settings
{
	/**
	 * option key for saving options
	 * @var string
	 */
	protected static $optionKey = '_hip_cta_settings';

	/**
	 * @var array
	 * default value
	 */

	protected static $defaults = [
		'hide_cta_on_mobile' => 'off',
		'mobile_width' => '480'
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
				$option[$key] = sanitize_text_field($value);
			}
		}
		update_option(self::$optionKey, $option);
	}
}
