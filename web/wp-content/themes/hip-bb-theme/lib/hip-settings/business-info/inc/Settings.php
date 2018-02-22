<?php

namespace BusinessInfo;

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
		'businessinfo_facebook_icon' => 'fa fa-facebook',
		'businessinfo_twitter_icon' => 'fa fa-twitter',
		'businessinfo_instagram_icon' => 'fa fa-instagram',
		'businessinfo_linkedin_icon' => 'fa fa-linkedin',
		'businessinfo_google_icon' => 'fa fa-google-plus',
		'businessinfo_youtube_icon' => 'fa fa-youtube',
        'businessinfo_pinterest_icon' => 'fa fa-pinterest',
		'social_media_height' => '36px',
		'social_media_width' => '36px',
		'icon_font_size' => '18px',
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
