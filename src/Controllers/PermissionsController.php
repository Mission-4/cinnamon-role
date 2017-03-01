<?php

namespace Mission4\CinnamonRole\Controllers;

use Mission4\CinnamonRole\Models\Permission;

class PermissionsController {
	public function index()
	{
		$data = Permission::all();
		$data = $data->map(function($permission){
			return $permission->data;
		});

		return response()->json([
			'data' => $data
		], 200);
	}

	public function show($id)
	{
		$permission = Permission::findOrFail($id);
		$data = $permission->data;

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

		$data = $permission->data;

		return response()->json([
			'data' => $data
		], 201);
	}

	public function update($id)
	{
		$permission = Permission::findOrFail(request('data')['id']);
		$requestData = request('data');
		collect($requestData['attributes'] ?? [])->each(function($item, $key) use($permission){
			$permission[$key] = $item;
		});

		$roles = request('data')['relationships']['roles'] ?? [];
		// Set the roles
		if(collect($roles)->count()){
			$permission->roles()->detach();
			collect(collect($roles['data'] ?? []))->each(function($role) use ($permission){
				$permission->roles()->attach($role['id']);
			});
		}

		$permission->save();

		$data = $permission->data;

		return response()->json([
			'data' => $data
		], 200);
	}

	public function destroy($id)
	{
		Permission::find($id)->delete();

		return response()->json(null, 204);
	}
}