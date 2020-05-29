<?php

namespace Hip\Theme\Settings\General;

class API
{
	/**
	 * register custom endpoints
	 * @uses register_rest_route() wp function
	 */
	public function addRoutes()
	{
		register_rest_route('hip-api/v1/settings', '/general', [
			'methods'		=> 'POST',
			'callback'	=> [ $this, 'updateSettings' ],
			'permission_callback'	=> [ $this, 'permissions' ]
		]);
		
		register_rest_route('hip-api/v1/settings', '/general', [
			'methods'		=> 'GET',
			'callback'	=> [ $this, 'getSettings' ],
			'permission_callback'	=> [ $this, 'permissions' ]
		]);
	}
	/**
	 * permission callback for register_rest_route() function
	 * @uses current_user_can() wp function
	 * @return boolean
	 */
	public function permissions()
	{
		return current_user_can('manage_options');
	}
	/**
	 * callback for register_rest_route() function
	 * response to update settings by api
	 * @param mixed
	 * @uses saveSettings() method of Settings class
	 * @return mixed
	 */
	public function updateSettings(\WP_REST_Request $request)
	{

		Settings::saveSettings($request->get_params());
		return rest_ensure_response(Settings::getSettings())->set_status(201);
	}
	/**
	 * callback for register_rest_route() function
	 * response to get settings by api
	 * @param mixed
	 * @uses getSettings() method of Settings class
	 * @return array
	 */
	public function getSettings(\WP_REST_Request $request)
	{
		return rest_ensure_response(Settings::getSettings());
	}
}
