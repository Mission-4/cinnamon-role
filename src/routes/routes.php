<?php

Route::group(['prefix' => 'api/cinnamonrole'], function(){
	// Permissions
	Route::get('permissions', 'Mission4\CinnamonRole\Controllers\PermissionsController@index');
	Route::post('permissions', 'Mission4\CinnamonRole\Controllers\PermissionsController@store');

	// Roles
	Route::get('roles', 'Mission4\CinnamonRole\Controllers\RolesController@index');
});