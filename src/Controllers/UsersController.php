<?php

namespace Mission4\CinnamonRole\Controllers;

use App\User;

class UsersController {
	public function update($id)
	{
		// Get the Initial Data
		$user = User::findOrFail(request('data')['id']);
		$requestData = request('data');
		$role = request('data')['relationships']['role'] ?? [];

		if(collect($role['data'])->count()){
			$user->role_id = $role['data']['id'];
		} else {
			$user->role_id = null;
		}

		// Save the role
		$user->save();

		// Return the data
		return response()->json([
			'data' => $user->data
		], 200);
	}
}