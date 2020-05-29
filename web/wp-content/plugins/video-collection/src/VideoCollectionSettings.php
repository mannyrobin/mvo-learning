<?php

namespace HipVideoCollection;

class Settings
{
	/**
	 * option key for saving options
	 * @var string
	 */
	protected static $optionKey = '_video_collection_settings';

	/**
	 * @var array
	 * default value
	 */

	protected static $defaults = [
		'video_archive_title' => 'Video Collection',
		'video_archive_slug'  => 'video-collection',
		'embed_max_width'	  => '900'
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
		foreach (self::$defaults as $key => $value) {
			if (!isset($option[$key])) {
				$option[$key] = $value;
			}
		}

		update_option(self::$optionKey, $option);
	}
}
