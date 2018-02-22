<?php

namespace Tabbar;

use Tabbar\Settings as Settings;

class API
{
	public function addRoutes()
	{
		register_rest_route('hip-api/v1/settings', '/tabbar', [
			'methods'		=> 'POST',
			'callback'	=> [ $this, 'updateSettings' ],
			'permission_callback'	=> [ $this, 'permissions' ]
		]);
		
		register_rest_route('hip-api/v1/settings', '/tabbar', [
			'methods'		=> 'GET',
			'callback'	=> [ $this, 'getSettings' ],
			'permission_callback'	=> [ $this, 'permissions' ]
		]);
	}
	
	public function permissions()
	{
		return current_user_can('manage_options');
	}
	
	public function updateSettings(\WP_REST_Request $request)
	{
		Settings::saveSettings($request->get_params());
		return rest_ensure_response(Settings::getSettings())->set_status(201);
	}
	
	public function getSettings(\WP_REST_Request $request)
	{
		return rest_ensure_response(Settings::getSettings());
	}
}
