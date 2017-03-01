<?php

Route::group(['prefix' => 'api/cinnamonrole'], function(){
	// Permissions
	Route::get('permissions', 'Mission4\CinnamonRole\Controllers\PermissionsController@index');
	Route::get('permissions/{permission}', 'Mission4\CinnamonRole\Controllers\PermissionsController@show');
	Route::post('permissions', 'Mission4\CinnamonRole\Controllers\PermissionsController@store');
	Route::patch('permissions/{permission}', 'Mission4\CinnamonRole\Controllers\PermissionsController@update');

	// Roles
	Route::get('roles', 'Mission4\CinnamonRole\Controllers\RolesController@index');
});