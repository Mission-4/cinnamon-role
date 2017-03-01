<?php

namespace Mission4\CinnamonRole\Controllers;

use Mission4\CinnamonRole\Models\Role;

class RolesController {
	public function index()
	{
		$data = Role::all();
		$data = $data->map(function($role){
			return $role->data;
		});

		return response()->json([
			'data' => $data
		], 200);
	}
	
	public function show($id)
	{
		$role = Role::findOrFail($id);

		return response()->json([
			'data' => $role->data
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
		$role = Role::findOrFail(request('data')['id']);

		$requestData = request('data');
		$relationships = $requestData['relationships'] ?? [];
		$permissions = $relationships['permissions'] ?? [];
		$permissionsData = $permissions['data'] ?? [];

		$attributes = $requestData['attributes'] ?? [];
		collect($attributes)->each(function($item, $key) use($role){
			$role[$key] = $item;
		});

		if(collect($permissions)->count()){
			$role->permissions()->detach();
			collect(collect($permissionsData))->each(function($permission) use ($role){
				$role->permissions()->attach($permission['id']);
			});
		}

		$role->save();

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