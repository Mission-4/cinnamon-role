<?php

namespace Mission4\CinnamonRole\Controllers;

use Mission4\CinnamonRole\Models\Permission;

class PermissionsController {
	public function index()
	{
		$data = Permission::all();
		$data = $data->map(function($permission){
			return [
				"id" => $permission->id,
				"type" => "permission",
				"attributes" => $permission->attributes
			];
		});

		return response()->json([
			'data' => $data
		], 200);
	}
}