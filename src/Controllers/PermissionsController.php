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
				"type" => "permissions",
				"attributes" => $permission->attributes
			];
		});

		return response()->json([
			'data' => $data
		], 200);
	}

	public function store()
	{
		$permission = new Permission();
		$permission->name = request('data')['attributes']['name'];
		$permission->slug = request('data')['attributes']['slug'];
		$permission->save();

		$data = [
			"id" => $permission->id,
			"type" => "permissions",
			"attributes" => $permission->attributes
		];

		return response()->json([
			'data' => $data
		], 201);
	}
}