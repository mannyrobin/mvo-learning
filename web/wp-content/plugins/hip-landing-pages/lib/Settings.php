<?php

namespace Hip\LP;

class Settings
{
    protected static $optionKey = '_hip_lp_settings';
    protected static $defaults = [
        'lp_label'     => 'Landing Page',
        'lp_slug'      => 'lp',
        'lp_cat_label' => 'LP Categories',
        'lp_cat_slug'  => 'lp-categories',
    ];

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
    }

    public function getOptions()
    {
        return Settings::getSettings();
    }
}
