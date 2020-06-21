<?php

namespace Hip\Theme\Settings\BusinessInfo;

class Settings
{
	/**
	 * option key for saving options
	 * @var string
	 */
	protected static $optionKey = '_business_info_settings';

	/**
	 * set default options
	 * @var array
	 */
	protected static $defaults = [
		'social_media_height' => '36px',
		'social_media_width' => '36px',
        'icon_font_size' => '18px',
        'businessinfo_specialty' => ''
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
	 * @return mixed
	 * @param array
	 */
	public static function saveSettings(array $settings)
	{
		$option = [];

		foreach ($settings as $key => $value) {
			if (!empty($value)) {
				if ($key =='businessinfo_phone_number') {
					if (!self::validate_phone_number($value)) {
						return false;
					} else {
						$option[$key] = sanitize_text_field($value);
					}
				}
				if ($key == 'businessinfo_address') {
					$option[$key]= $value;
					continue;
				}
				if($key == 'social_media'){
					foreach ($value as $media){
						$option[$key][] = [
							'icon' => sanitize_text_field($media['icon']),
							'link' => esc_url_raw($media['link'])
						];

					}
					continue;
				}
				$option[$key] = sanitize_text_field($value);
			}
		}
		update_option(self::$optionKey, $option);

		return true;
	}

	/**
	 * validation phone number usa
	 * @return string
	 * check usa regular expression
	 */
	private static function validate_phone_number($number)
	{
		$regxp = '/^(\+?1\s?)?[\s\-\.]?((\(\d{3}\) ?)|(\d{3}))[\s\-\.]?\d{3}[\s\-\.]?\d{4}$/';
		if (!preg_match($regxp, trim($number))){
			return false;
		} else {
			return true;
		}
	}
}
