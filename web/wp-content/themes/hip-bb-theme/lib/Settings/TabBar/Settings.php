<?php

namespace Hip\Theme\Settings\TabBar;

class Settings
{
	protected static $optionKey = '_tabbar_settings';
	protected static $defaults = [
		'tab'              => [
			[
				'name'   => 'Contact',
				'button' => 'svg',
				'icon'    => '',
				'type'   => 'link',
				'link'   => '#'
			],
			[
				'name'   => 'Services',
				'button' => 'svg',
				'icon'    => '',
				'type'   => 'menu',
				'link'   => ''
			],
			[
				'name'   => 'Conditions',
				'button' => 'svg',
				'icon'    => '',
				'type'   => 'menu',
				'link'   => ''
			],
			[
				'name'   => 'Menu',
				'button' => 'hamburger',
				'icon'    => '',
				'type'   => 'menu',
				'link'   => ''
			]
		],
		'enable_search'    => 'on',
		'max_width'        => 768,
		'bg_color'         => '#004964',
		'fg_color'         => '#ffffff',
		'selected_color'   => '#33cccc'
	];

	public static function getSettings()
	{
		$saved = get_option(self::$optionKey, []);

		if (!is_array($saved) || empty($saved)) {
			return self::$defaults;
		}
		$new_items = array_diff_key(self::$defaults, $saved);
		if (!empty($new_items)) {
			foreach ($new_items as $itemKey => $item) {
				$saved[$itemKey] = $item;
			}
		}
		return $saved;
	}

	public static function saveSettings(array $settings)
	{
		$option = [];


		if (!empty($settings['tab'])) {
			foreach ($settings['tab'] as $tab) {
				$tab['name'] = sanitize_text_field($tab['name']);
				$tab['link'] = esc_url_raw($tab['link']);
				$option['tab'][] = $tab;
			}
		}
		if ($settings['enable_search'] === 'on') {
			$option['enable_search'] = true;
		} else {
			$option['enable_search'] = false;
		}
		if (!empty($settings['search_bg'])) {
			$option['search_bg'] = sanitize_text_field($settings['search_bg']);
		}
		if (!empty($settings['search_btn_color'])) {
			$option['search_btn_color'] = sanitize_text_field($settings['search_btn_color']);
		}

		if (!empty($settings['max_width'])) {
			$option['max_width'] = absint($settings['max_width']);
		}

		if (!empty($settings['bg_color'])) {
			$option['bg_color'] = sanitize_text_field($settings['bg_color']);
			$option['fg_color'] = sanitize_text_field($settings['fg_color']);
			$option['selected_color'] = sanitize_text_field($settings['selected_color']);
		}
		update_option(self::$optionKey, $option);
	}
}
