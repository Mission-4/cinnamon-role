<?php

namespace Mission4\CinnamonRole\Controllers;

use Mission4\CinnamonRole\Models\Role;

class RolesController {
	public function index()
	{
		$data = Role::all();
		$data = $data->map(function($role){
			return [
				"id" => $role->id,
				"type" => "role",
				"attributes" => $role->attributes
			];
		});

		return response()->json([
			'data' => $data
		], 200);
	}
}