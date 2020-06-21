<?php

namespace Hip\Conditions;

class Settings
{
	protected static $optionKey = '_hip_conditions_settings';
	
	protected static $defaults = [
		'condition_singular_label'	=> 'Condition',
		'condition_plural_label'    => 'Conditions',
		'condition_slug'      		=> 'conditions',
		'condition_cat_label' 		=> 'Condition Categories',
		'condition_cat_slug'  		=> 'condition-categories',
	];

	protected $options;

	public static function getSettings()
	{
		$saved = get_option(self::$optionKey, []);

		if (!is_array($saved) || empty($saved)) {
			return self::$defaults;
		}

		return $saved;
	}

	public static function saveSettings(array $settings)
	{
		$option = [];
		foreach ($settings as $key => $setting) {
			$option[$key] = sanitize_text_field($setting);
		}

		foreach (self::$defaults as $key => $value) {
			if (!isset($option[$key])) {
				$option[$key] = $value;
			}
		}

		update_option(self::$optionKey, $option);
		flush_rewrite_rules();
    }

	public function getOptions()
	{
		if ($this->options) {
			return $this->options;
		}
		
		$this->options = Settings::getSettings();
		return $this->options;
	}

	public function saveOptions($options)
	{
		$this->options = $options;
		Settings::saveSettings($options);
	}
}
