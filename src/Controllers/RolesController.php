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
				"type" => "roles",
				"attributes" => $role->attributes
			];
		});

		return response()->json([
			'data' => $data
		], 200);
	}
	public function show($id)
	{
		$role = Role::findOrFail($id);
		$data = [
			"id" => $role->id,
			"type" => "roles",
			"attributes" => $role->attributes,
			"relationships" => [
				"permissions" => [
					
				] 
			]
		];

		return response()->json([
			'data' => $data
		], 200);
	}

	public function store()
	{
		$role = new Role();
		$role->name = request('data')['attributes']['name'];
		$role->slug = request('data')['attributes']['slug'];
		$role->save();

		$data = [
			"id" => $role->id,
			"type" => "roles",
			"attributes" => $role->attributes
		];

		return response()->json([
			'data' => $data
		], 201);
	}

	public function update($id)
	{
		$role = Role::findOrFail(request('data')['id']);
		$requestData = request('data');
		collect($requestData['attributes'])->each(function($item, $key) use($role){
			$role[$key] = $item;
		});
		$role->save();

		$data = [
			"id" => $role->id,
			"type" => "roles",
			"attributes" => $role->attributes
		];

		return response()->json([
			'data' => $data
		], 200);
	}

	public function destroy($id)
	{
		Role::find($id)->delete();

		return response()->json(null, 204);
	}
}