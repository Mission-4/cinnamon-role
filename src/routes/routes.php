<?php

Route::group(['prefix' => 'api/cinnamonrole'], function () {
    // Permissions
    Route::get('permissions', 'Mission4\CinnamonRole\Controllers\PermissionsController@index');
    Route::get('permissions/{permission}', 'Mission4\CinnamonRole\Controllers\PermissionsController@show');
    Route::post('permissions', 'Mission4\CinnamonRole\Controllers\PermissionsController@store');
    Route::patch('permissions/{permission}', 'Mission4\CinnamonRole\Controllers\PermissionsController@update');
    Route::delete('permissions/{permission}', 'Mission4\CinnamonRole\Controllers\PermissionsController@destroy');

    // Roles
    Route::get('roles', 'Mission4\CinnamonRole\Controllers\RolesController@index');
    Route::get('roles/{role}', 'Mission4\CinnamonRole\Controllers\RolesController@show');
    Route::post('roles', 'Mission4\CinnamonRole\Controllers\RolesController@store');
    Route::patch('roles/{role}', 'Mission4\CinnamonRole\Controllers\RolesController@update');
    Route::delete('roles/{role}', 'Mission4\CinnamonRole\Controllers\RolesController@destroy');

    // Users
    Route::get('/users', "Mission4\CinnamonRole\Controllers\UsersController@index");
    Route::patch('/users/{user}', "Mission4\CinnamonRole\Controllers\UsersController@update");
});
