<?php
namespace Hip\Theme;

/**
 * Hip settings options
 */
class Settings
{
	public $settings;

	public function __construct()
	{
		$this->init_settings_modules();
		$this->settings = array_merge(Settings\General\Settings::getSettings(),Settings\BusinessInfo\Settings::getSettings(),Settings\TabBar\Settings::getSettings());
	}

	public function init_settings_modules()
	{
		new Settings\General();
		new Settings\BusinessInfo();
		new Settings\TabBar();
	}
}
