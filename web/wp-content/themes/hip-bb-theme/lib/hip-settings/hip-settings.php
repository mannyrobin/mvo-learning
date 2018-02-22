<?php

/**
 * Hip settings options
 */
class HipSettings
{
	public function __construct()
	{
		$this->init_settings_modules();
	}
	public function init_settings_modules()
	{
		require_once __DIR__. '/general/GeneralSettings.php';
		require_once __DIR__ . '/tabbar/tabbar-init.php';
		require_once __DIR__. '/business-info/business-info-init.php';
	}
}
new HipSettings();
