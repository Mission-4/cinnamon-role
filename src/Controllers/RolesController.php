<?php

namespace Mission4\CinnamonRole\Controllers;

use Mission4\CinnamonRole\Models\Role;

class RolesController {
	public function index()
	{

		return response()->json([
			'data' => Role::all()->map->data
		], 200);
	}

	public function show($id)
	{
		return response()->json([
			'data' => Role::findOrFail($id)->data
		], 200);
	}

	public function store()
	{
		$role = new Role();
		$role->name = request('data')['attributes']['name'];
		$role->slug = request('data')['attributes']['slug'];
		$role->save();

		return response()->json([
			'data' => $role->data
		], 201);
	}

	public function update($id)
	{
		// Get the Initial Data
		$role = Role::findOrFail(request('data')['id']);
		$requestData = request('data');
		$attributes = $requestData['attributes'] ?? [];
		$relationships = $requestData['relationships'] ?? [];
		$permissions = $relationships['permissions'] ?? [];
		$permissionsData = $permissions['data'] ?? [];

		// Set the attributes
		collect($attributes)->each(function($item, $key) use($role){
			$role[$key] = $item;
		});

		// Set the permissions
		if(collect($permissions)->count()){
			$role->permissions()->detach();
			collect(collect($permissionsData))->each(function($permission) use ($role){
				$role->permissions()->attach($permission['id']);
			});
		}

		// Save the role
		$role->save();

		// Return the data
		return response()->json([
			'data' => $role->data
		], 200);
	}

	public function destroy($id)
	{
		Role::find($id)->delete();

		return response()->json(null, 204);
	}
}